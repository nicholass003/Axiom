<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettings;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettingsWeightFloat;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettingsWeightString;
use Nicholass003\Axiom\Enum\AttributeLayerSettingsWeightType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class AttributeLayerSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeLayerSettings{
		$priority = LE::readSignedInt($in);

		$weightType = AttributeLayerSettingsWeightType::tryFrom(VarInt::readUnsignedInt($in));
		$weight = match($weightType){
			AttributeLayerSettingsWeightType::FLOAT => $codec->read(AttributeLayerSettingsWeightFloat::class, $in),
			AttributeLayerSettingsWeightType::STRING => $codec->read(AttributeLayerSettingsWeightString::class, $in),
			default => throw new \RuntimeException("Unknown AttributeLayerSettingsWeight type"),
		};

		$enabled = CodecHelper::readBool($in);
		$transitionsPaused = CodecHelper::readBool($in);

		return new AttributeLayerSettings(
			priority: $priority,
			weight: $weight,
			enabled: $enabled,
			transitionsPaused: $transitionsPaused
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeLayerSettings);

		LE::writeSignedInt($out, $data->priority);
		VarInt::writeUnsignedInt($out, $data->weight->type->value);
		$codec->write($data->weight::class, $out, $data->weight);
		CodecHelper::writeBool($out, $data->enabled);
		CodecHelper::writeBool($out, $data->transitionsPaused);
	}
}
