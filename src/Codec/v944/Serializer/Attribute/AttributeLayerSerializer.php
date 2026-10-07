<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeEnvironment;
use Nicholass003\Axiom\Data\Type\AttributeLayer;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class AttributeLayerSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeLayer{
		$name = CodecHelper::readString($in);
		$dimension = VarInt::readUnsignedInt($in);
		$settings = $codec->read(AttributeLayerSettings::class, $in);

		$attributes = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$attributes[] = $codec->read(AttributeEnvironment::class, $in);
		}

		return new AttributeLayer(
			name: $name,
			dimension: $dimension,
			settings: $settings,
			attributes: $attributes
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeLayer);

		CodecHelper::writeString($out, $data->name);
		VarInt::writeUnsignedInt($out, $data->dimension);
		$codec->write(AttributeLayerSettings::class, $out, $data->settings);

		VarInt::writeUnsignedInt($out, count($data->attributes));
		foreach($data->attributes as $attribute){
			$codec->write(AttributeEnvironment::class, $out, $attribute);
		}
	}
}
