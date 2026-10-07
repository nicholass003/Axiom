<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConditionalTransformationData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeConditionalTransformationDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeConditionalTransformationData{
		return new BiomeConditionalTransformationData(
			weightedBiomes: CodecHelper::readList($in, fn($in) => $codec->read(BiomeWeightedData::class, $in)),
			conditionJSON: LE::readSignedShort($in),
			minPassingNeighbors: LE::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeConditionalTransformationData);

		CodecHelper::writeList($out, $data->weightedBiomes, fn($out, $v) => $codec->write(BiomeWeightedData::class, $out, $v));
		LE::writeSignedShort($out, $data->conditionJSON);
		LE::writeUnsignedInt($out, $data->minPassingNeighbors);
	}
}
