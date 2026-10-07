<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMultinoiseGenRulesData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeMultinoiseGenRulesDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeMultinoiseGenRulesData{
		return new BiomeMultinoiseGenRulesData(
			temperature: LE::readFloat($in),
			humidity: LE::readFloat($in),
			altitude: LE::readFloat($in),
			weirdness: LE::readFloat($in),
			weight: LE::readFloat($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeMultinoiseGenRulesData);

		LE::writeFloat($out, $data->temperature);
		LE::writeFloat($out, $data->humidity);
		LE::writeFloat($out, $data->altitude);
		LE::writeFloat($out, $data->weirdness);
		LE::writeFloat($out, $data->weight);
	}
}
