<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeClimateData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeClimateDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeClimateData{
		return new BiomeClimateData(
			temperature: LE::readFloat($in),
			downfall: LE::readFloat($in),
			snowAccumulationMin: LE::readFloat($in),
			snowAccumulationMax: LE::readFloat($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeClimateData);

		LE::writeFloat($out, $data->temperature);
		LE::writeFloat($out, $data->downfall);
		LE::writeFloat($out, $data->snowAccumulationMin);
		LE::writeFloat($out, $data->snowAccumulationMax);
	}
}
