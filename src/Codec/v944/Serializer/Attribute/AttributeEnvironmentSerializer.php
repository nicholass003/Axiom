<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeEnvironment;
use Nicholass003\Axiom\Data\Type\AttributeValue;
use Nicholass003\Axiom\Data\Type\AttributeValueBool;
use Nicholass003\Axiom\Data\Type\AttributeValueColor;
use Nicholass003\Axiom\Data\Type\AttributeValueFloat;
use Nicholass003\Axiom\Enum\AttributeValueType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class AttributeEnvironmentSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeEnvironment{
		$name = CodecHelper::readString($in);

		$fromAttribute = CodecHelper::readOptional($in, function(ByteBufferReader $in) use ($codec) : AttributeValue {
			$type = AttributeValueType::fromWireId(VarInt::readUnsignedInt($in));
			return match($type){
				AttributeValueType::BOOL => $codec->read(AttributeValueBool::class, $in),
				AttributeValueType::FLOAT => $codec->read(AttributeValueFloat::class, $in),
				AttributeValueType::COLOR => $codec->read(AttributeValueColor::class, $in),
				default => throw new \RuntimeException("Unknown AttributeValue type"),
			};
		});

		$attributeType = AttributeValueType::fromWireId(VarInt::readUnsignedInt($in));
		$attribute = match($attributeType){
			AttributeValueType::BOOL => $codec->read(AttributeValueBool::class, $in),
			AttributeValueType::FLOAT => $codec->read(AttributeValueFloat::class, $in),
			AttributeValueType::COLOR => $codec->read(AttributeValueColor::class, $in),
			default => throw new \RuntimeException("Unknown AttributeValue type"),
		};

		$toAttribute = CodecHelper::readOptional($in, function(ByteBufferReader $in) use ($codec) : AttributeValue {
			$type = AttributeValueType::fromWireId(VarInt::readUnsignedInt($in));
			return match($type){
				AttributeValueType::BOOL => $codec->read(AttributeValueBool::class, $in),
				AttributeValueType::FLOAT => $codec->read(AttributeValueFloat::class, $in),
				AttributeValueType::COLOR => $codec->read(AttributeValueColor::class, $in),
				default => throw new \RuntimeException("Unknown AttributeValue type"),
			};
		});

		$currentTransitionTicks = LE::readUnsignedInt($in);
		$totalTransitionTicks = LE::readUnsignedInt($in);
		$easeType = CodecHelper::readString($in);

		return new AttributeEnvironment(
			name: $name,
			fromAttribute: $fromAttribute,
			attribute: $attribute,
			toAttribute: $toAttribute,
			currentTransitionTicks: $currentTransitionTicks,
			totalTransitionTicks: $totalTransitionTicks,
			easeType: $easeType
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeEnvironment);

		CodecHelper::writeString($out, $data->name);

		CodecHelper::writeOptional($out, $data->fromAttribute, function(ByteBufferWriter $out, AttributeValue $value) use ($codec) {
			VarInt::writeUnsignedInt($out, $value->type->toWireId());
			match(true){
				$value instanceof AttributeValueBool => $codec->write(AttributeValueBool::class, $out, $value),
				$value instanceof AttributeValueFloat => $codec->write(AttributeValueFloat::class, $out, $value),
				$value instanceof AttributeValueColor => $codec->write(AttributeValueColor::class, $out, $value),
				default => throw new \RuntimeException("Unknown AttributeValue type"),
			};
		});

		VarInt::writeUnsignedInt($out, $data->attribute->type->toWireId());
		match(true){
			$data->attribute instanceof AttributeValueBool => $codec->write(AttributeValueBool::class, $out, $data->attribute),
			$data->attribute instanceof AttributeValueFloat => $codec->write(AttributeValueFloat::class, $out, $data->attribute),
			$data->attribute instanceof AttributeValueColor => $codec->write(AttributeValueColor::class, $out, $data->attribute),
			default => throw new \RuntimeException("Unknown AttributeValue type"),
		};

		CodecHelper::writeOptional($out, $data->toAttribute, function(ByteBufferWriter $out, AttributeValue $value) use ($codec) {
			VarInt::writeUnsignedInt($out, $value->type->toWireId());
			match(true){
				$value instanceof AttributeValueBool => $codec->write(AttributeValueBool::class, $out, $value),
				$value instanceof AttributeValueFloat => $codec->write(AttributeValueFloat::class, $out, $value),
				$value instanceof AttributeValueColor => $codec->write(AttributeValueColor::class, $out, $value),
				default => throw new \RuntimeException("Unknown AttributeValue type"),
			};
		});

		LE::writeUnsignedInt($out, $data->currentTransitionTicks);
		LE::writeUnsignedInt($out, $data->totalTransitionTicks);
		CodecHelper::writeString($out, $data->easeType);
	}
}
