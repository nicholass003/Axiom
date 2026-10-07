<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeValueFloat;
use Nicholass003\Axiom\Enum\AttributeValueType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AttributeValueFloatSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeValueFloat{
		$value = LE::readFloat($in);
		$operation = CodecHelper::readString($in);

		return new AttributeValueFloat(
			value: $value,
			operation: $operation
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeValueFloat);

		LE::writeFloat($out, $data->value);
		CodecHelper::writeString($out, $data->operation);
	}
}
