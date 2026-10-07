<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Debug;

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
		return new PacketShapeData(
			networkId: VarInt::readUnsignedLong($in),
			type: CodecHelper::readOptional($in, fn($in) => ScriptDebugShapeType::safe(Byte::readUnsigned($in))),
			location: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			scale: CodecHelper::readOptional($in, LE::readFloat(...)),
			rotation: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			totalTimeLeft: CodecHelper::readOptional($in, LE::readFloat(...)),
			colorArgb: CodecHelper::readOptional($in, LE::readUnsignedInt(...)),
			text: CodecHelper::readOptional($in, CodecHelper::readString(...)),
			boxBound: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			lineEndLocation: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			arrowHeadLength: CodecHelper::readOptional($in, LE::readFloat(...)),
			arrowHeadRadius: CodecHelper::readOptional($in, LE::readFloat(...)),
			segments: CodecHelper::readOptional($in, Byte::readUnsigned(...))
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
		CodecHelper::writeOptional($out, $data->text, fn($o, $v) => CodecHelper::writeString($o, $v));
		CodecHelper::writeOptional($out, $data->boxBound, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->lineEndLocation, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->arrowHeadLength, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->arrowHeadRadius, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->segments, fn($o, $v) => Byte::writeUnsigned($o, $v));
	}
}
