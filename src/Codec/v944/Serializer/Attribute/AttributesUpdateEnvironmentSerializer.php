<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeEnvironment;
use Nicholass003\Axiom\Data\Type\AttributesUpdateEnvironment;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class AttributesUpdateEnvironmentSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributesUpdateEnvironment{
		$name = CodecHelper::readString($in);
		$dimension = VarInt::readUnsignedInt($in);

		$attributes = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$attributes[] = $codec->read(AttributeEnvironment::class, $in);
		}

		return new AttributesUpdateEnvironment(
			name: $name,
			dimension: $dimension,
			attributes: $attributes
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributesUpdateEnvironment);

		CodecHelper::writeString($out, $data->name);
		VarInt::writeUnsignedInt($out, $data->dimension);

		VarInt::writeUnsignedInt($out, count($data->attributes));
		foreach($data->attributes as $attribute){
			$codec->write(AttributeEnvironment::class, $out, $attribute);
		}
	}
}
