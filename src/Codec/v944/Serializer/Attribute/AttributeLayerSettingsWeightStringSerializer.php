<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettingsWeightString;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class AttributeLayerSettingsWeightStringSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeLayerSettingsWeightString{
		$value = CodecHelper::readString($in);

		return new AttributeLayerSettingsWeightString(
			value: $value
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeLayerSettingsWeightString);

		CodecHelper::writeString($out, $data->value);
	}
}
