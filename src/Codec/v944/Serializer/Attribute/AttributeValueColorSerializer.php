<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeValueColor;
use Nicholass003\Axiom\Data\Type\AttributeValueColorArray;
use Nicholass003\Axiom\Data\Type\AttributeValueColorString;
use Nicholass003\Axiom\Enum\AttributeValueColorType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class AttributeValueColorSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeValueColor{
		$type = AttributeValueColorType::fromWireId(VarInt::readUnsignedInt($in));

		$value = match($type){
			AttributeValueColorType::HEX => $codec->read(AttributeValueColorString::class, $in),
			AttributeValueColorType::RGB => $codec->read(AttributeValueColorArray::class, $in),
			default => throw new \RuntimeException("Unknown AttributeValueColor type"),
		};

		$operation = CodecHelper::readString($in);

		return new AttributeValueColor(
			value: $value,
			operation: $operation
		);
	}

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof AttributeValueColor);

        VarInt::writeUnsignedInt($out, $data->value->type->toWireId());
        match(true){
            $data->value instanceof AttributeValueColorString => $codec->write(AttributeValueColorString::class, $out, $data->value),
            $data->value instanceof AttributeValueColorArray => $codec->write(AttributeValueColorArray::class, $out, $data->value),
            default => throw new \RuntimeException("Unknown AttributeValueColor type"),
        };
        CodecHelper::writeString($out, $data->operation);
    }
}
