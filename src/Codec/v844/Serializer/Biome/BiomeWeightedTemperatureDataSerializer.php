<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedTemperatureData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class BiomeWeightedTemperatureDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeWeightedTemperatureData{
		return new BiomeWeightedTemperatureData(
			temperature: VarInt::readSignedInt($in),
			weight: LE::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeWeightedTemperatureData);

		VarInt::writeSignedInt($out, $data->temperature);
		LE::writeUnsignedInt($out, $data->weight);
	}
}
