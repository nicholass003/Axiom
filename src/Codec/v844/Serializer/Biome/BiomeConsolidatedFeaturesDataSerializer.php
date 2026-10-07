<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeatureData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeaturesData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeConsolidatedFeaturesDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeConsolidatedFeaturesData{
		return new BiomeConsolidatedFeaturesData(
			features: CodecHelper::readList($in, fn($in) => $codec->read(BiomeConsolidatedFeatureData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeConsolidatedFeaturesData);

		CodecHelper::writeList($out, $data->features, fn($out, $v) => $codec->write(BiomeConsolidatedFeatureData::class, $out, $v));
	}
}
