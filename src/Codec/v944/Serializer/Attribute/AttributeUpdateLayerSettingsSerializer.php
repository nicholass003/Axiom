<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettings;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayerSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class AttributeUpdateLayerSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeUpdateLayerSettings{
		$name = CodecHelper::readString($in);
		$dimension = VarInt::readUnsignedInt($in);
		$settings = $codec->read(AttributeLayerSettings::class, $in);

		return new AttributeUpdateLayerSettings(
			name: $name,
			dimension: $dimension,
			settings: $settings
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeUpdateLayerSettings);

		CodecHelper::writeString($out, $data->name);
		VarInt::writeUnsignedInt($out, $data->dimension);
		$codec->write(AttributeLayerSettings::class, $out, $data->settings);
	}
}
