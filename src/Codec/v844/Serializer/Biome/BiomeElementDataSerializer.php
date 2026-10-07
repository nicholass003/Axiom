<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeElementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class BiomeElementDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeElementData{
		return new BiomeElementData(
			noiseFrequencyScale: LE::readFloat($in),
			noiseLowerBound: LE::readFloat($in),
			noiseUpperBound: LE::readFloat($in),
			heightMinType: VarInt::readSignedInt($in),
			heightMin: LE::readSignedShort($in),
			heightMaxType: VarInt::readSignedInt($in),
			heightMax: LE::readSignedShort($in),
			surfaceMaterial: $codec->read(BiomeSurfaceMaterialData::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeElementData);

		LE::writeFloat($out, $data->noiseFrequencyScale);
		LE::writeFloat($out, $data->noiseLowerBound);
		LE::writeFloat($out, $data->noiseUpperBound);
		VarInt::writeSignedInt($out, $data->heightMinType);
		LE::writeSignedShort($out, $data->heightMin);
		VarInt::writeSignedInt($out, $data->heightMaxType);
		LE::writeSignedShort($out, $data->heightMax);
		$codec->write(BiomeSurfaceMaterialData::class, $out, $data->surfaceMaterial);
	}
}
