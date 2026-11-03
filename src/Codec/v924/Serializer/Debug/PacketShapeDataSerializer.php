<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Debug;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Debug\PacketShapeData;
use Nicholass003\Axiom\Enum\ScriptDebugShapeType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PacketShapeDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PacketShapeData{
		$networkId = VarInt::readUnsignedLong($in);
		$shapeType = CodecHelper::readOptional($in, fn($in) => ScriptDebugShapeType::safe(Byte::readUnsigned($in)));
		$location = CodecHelper::readOptional($in, CodecHelper::readVec3(...));
		$scale = CodecHelper::readOptional($in, LE::readFloat(...));
		$rotation = CodecHelper::readOptional($in, CodecHelper::readVec3(...));
		$totalTimeLeft = CodecHelper::readOptional($in, LE::readFloat(...));
		$colorArgb = CodecHelper::readOptional($in, LE::readUnsignedInt(...));
		$dimensionId = CodecHelper::readOptional($in, VarInt::readSignedInt(...));
		$attachedToEntityId = CodecHelper::readOptional($in, CodecHelper::readActorRuntimeId(...));

		$payloadType = VarInt::readUnsignedInt($in);

		if(
			($shapeType !== null && $payloadType !== $shapeType->getPayloadType() && $payloadType !== ScriptDebugShapeType::PAYLOAD_TYPE_NONE) ||
			($shapeType === null && $payloadType !== ScriptDebugShapeType::PAYLOAD_TYPE_NONE)
		){
			throw new \InvalidArgumentException("Unexpected payload type $payloadType for provided shape type " . ($shapeType?->name ?? "(not set)"));
		}

		$text = null;
		$boxBound = null;
		$lineEndLocation = null;
		$arrowHeadLength = null;
		$arrowHeadRadius = null;
		$segments = null;

		switch($payloadType){
			case ScriptDebugShapeType::PAYLOAD_TYPE_NONE:
				break;
			case ScriptDebugShapeType::PAYLOAD_TYPE_ARROW:
				$lineEndLocation = CodecHelper::readOptional($in, CodecHelper::readVec3(...));
				$arrowHeadLength = CodecHelper::readOptional($in, LE::readFloat(...));
				$arrowHeadRadius = CodecHelper::readOptional($in, LE::readFloat(...));
				$segments = CodecHelper::readOptional($in, Byte::readUnsigned(...));
				break;
			case ScriptDebugShapeType::PAYLOAD_TYPE_TEXT:
				$text = CodecHelper::readString($in);
				break;
			case ScriptDebugShapeType::PAYLOAD_TYPE_BOX:
				$boxBound = CodecHelper::readVec3($in);
				break;
			case ScriptDebugShapeType::PAYLOAD_TYPE_LINE:
				$lineEndLocation = CodecHelper::readVec3($in);
				break;
			case ScriptDebugShapeType::PAYLOAD_TYPE_CIRCLE_OR_SPHERE:
				$segments = Byte::readUnsigned($in);
				break;
			default:
				throw new \InvalidArgumentException("Unexpected shape payload type $payloadType");
		}

		return new PacketShapeData(
			networkId: $networkId,
			type: $shapeType,
			location: $location,
			scale: $scale,
			rotation: $rotation,
			totalTimeLeft: $totalTimeLeft,
			colorArgb: $colorArgb,
			text: $text,
			boxBound: $boxBound,
			lineEndLocation: $lineEndLocation,
			arrowHeadLength: $arrowHeadLength,
			arrowHeadRadius: $arrowHeadRadius,
			segments: $segments,
			dimensionId: $dimensionId,
			attachedToEntityId: $attachedToEntityId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PacketShapeData);

		VarInt::writeUnsignedLong($out, $data->networkId);
		CodecHelper::writeOptional($out, $data->type, fn($o, $v) => Byte::writeUnsigned($o, $v->value));
		CodecHelper::writeOptional($out, $data->location, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->scale, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->rotation, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->totalTimeLeft, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->colorArgb, fn($o, $v) => LE::writeUnsignedInt($o, $v));
		CodecHelper::writeOptional($out, $data->dimensionId, fn($o, $v) => VarInt::writeSignedInt($o, $v));
		CodecHelper::writeOptional($out, $data->attachedToEntityId, fn($o, $v) => CodecHelper::writeActorRuntimeId($o, $v));

		$payloadType = $data->type?->getPayloadType() ?? ScriptDebugShapeType::PAYLOAD_TYPE_NONE;
		if($data->type === null){
			VarInt::writeUnsignedInt($out, ScriptDebugShapeType::PAYLOAD_TYPE_NONE);
		} else {
			switch($data->type){
				case ScriptDebugShapeType::ARROW:
					VarInt::writeUnsignedInt($out, $data->type->getPayloadType());
					CodecHelper::writeOptional($out, $data->lineEndLocation, fn($o, $v) => CodecHelper::writeVec3($o, $v));
					CodecHelper::writeOptional($out, $data->arrowHeadLength, fn($o, $v) => LE::writeFloat($o, $v));
					CodecHelper::writeOptional($out, $data->arrowHeadRadius, fn($o, $v) => LE::writeFloat($o, $v));
					CodecHelper::writeOptional($out, $data->segments, fn($o, $v) => Byte::writeUnsigned($o, $v));
					break;
				case ScriptDebugShapeType::TEXT:
					if($data->text !== null){
						VarInt::writeUnsignedInt($out, $data->type->getPayloadType());
						CodecHelper::writeString($out, $data->text);
					} else {
						VarInt::writeUnsignedInt($out, ScriptDebugShapeType::PAYLOAD_TYPE_NONE);
					}
					break;
				case ScriptDebugShapeType::BOX:
					if($data->boxBound !== null){
						VarInt::writeUnsignedInt($out, $data->type->getPayloadType());
						CodecHelper::writeVec3($out, $data->boxBound);
					} else {
						VarInt::writeUnsignedInt($out, ScriptDebugShapeType::PAYLOAD_TYPE_NONE);
					}
					break;
				case ScriptDebugShapeType::LINE:
					if($data->lineEndLocation !== null){
						VarInt::writeUnsignedInt($out, $data->type->getPayloadType());
						CodecHelper::writeVec3($out, $data->lineEndLocation);
					} else {
						VarInt::writeUnsignedInt($out, ScriptDebugShapeType::PAYLOAD_TYPE_NONE);
					}
					break;
				case ScriptDebugShapeType::CIRCLE:
				case ScriptDebugShapeType::SPHERE:
					if($data->segments !== null){
						VarInt::writeUnsignedInt($out, $data->type->getPayloadType());
						Byte::writeUnsigned($out, $data->segments);
					} else {
						VarInt::writeUnsignedInt($out, ScriptDebugShapeType::PAYLOAD_TYPE_NONE);
					}
					break;
				default:
					throw new \LogicException("Unknown payload type $payloadType");
			}
		}
	}
}
