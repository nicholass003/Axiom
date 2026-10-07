<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeatureData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeScatterParamData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeConsolidatedFeatureDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeConsolidatedFeatureData{
		return new BiomeConsolidatedFeatureData(
			scatter: $codec->read(BiomeScatterParamData::class, $in),
			feature: LE::readSignedShort($in),
			identifier: LE::readSignedShort($in),
			pass: LE::readSignedShort($in),
			useInternal: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeConsolidatedFeatureData);

		$codec->write(BiomeScatterParamData::class, $out, $data->scatter);
		LE::writeSignedShort($out, $data->feature);
		LE::writeSignedShort($out, $data->identifier);
		LE::writeSignedShort($out, $data->pass);
		CodecHelper::writeBool($out, $data->useInternal);
	}
}
