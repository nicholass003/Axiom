<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConditionalTransformationData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeLegacyWorldGenRulesData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeLegacyWorldGenRulesDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeLegacyWorldGenRulesData{
		return new BiomeLegacyWorldGenRulesData(
			legacyPreHills: CodecHelper::readList($in, fn($in) => $codec->read(BiomeConditionalTransformationData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeLegacyWorldGenRulesData);

		CodecHelper::writeList($out, $data->legacyPreHills, fn($out, $v) => $codec->write(BiomeConditionalTransformationData::class, $out, $v));
	}
}
