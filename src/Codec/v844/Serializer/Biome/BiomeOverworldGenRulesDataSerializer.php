<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConditionalTransformationData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeOverworldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedTemperatureData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeOverworldGenRulesDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeOverworldGenRulesData{
		return new BiomeOverworldGenRulesData(
			hillTransformations: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedData::class, $in)),
			mutateTransformations: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedData::class, $in)),
			riverTransformations: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedData::class, $in)),
			shoreTransformations: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedData::class, $in)),
			preHillsEdges: CodecHelper::readList($in, fn($in) => $codec->read(BiomeConditionalTransformationData::class, $in)),
			postShoreEdges: CodecHelper::readList($in, fn($in) => $codec->read(BiomeConditionalTransformationData::class, $in)),
			climates: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedTemperatureData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeOverworldGenRulesData);

		CodecHelper::writeList($out, $data->hillTransformations, fn($out, $v) => $codec->write(BiomeWeightedData::class, $out, $v));
		CodecHelper::writeList($out, $data->mutateTransformations, fn($out, $v) => $codec->write(BiomeWeightedData::class, $out, $v));
		CodecHelper::writeList($out, $data->riverTransformations, fn($out, $v) => $codec->write(BiomeWeightedData::class, $out, $v));
		CodecHelper::writeList($out, $data->shoreTransformations, fn($out, $v) => $codec->write(BiomeWeightedData::class, $out, $v));
		CodecHelper::writeList($out, $data->preHillsEdges, fn($out, $v) => $codec->write(BiomeConditionalTransformationData::class, $out, $v));
		CodecHelper::writeList($out, $data->postShoreEdges, fn($out, $v) => $codec->write(BiomeConditionalTransformationData::class, $out, $v));
		CodecHelper::writeList($out, $data->climates, fn($out, $v) => $codec->write(BiomeWeightedTemperatureData::class, $out, $v));
	}
}
