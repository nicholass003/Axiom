<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\BiomeDefinitionData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeDefinitionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeDefinitionData{
		$nameIndex = LE::readUnsignedShort($in);
		$id = LE::readUnsignedShort($in);
		$temperature = LE::readFloat($in);
		$downfall = LE::readFloat($in);
		$foliageSnow = LE::readFloat($in);
		$depth = LE::readFloat($in);
		$scale = LE::readFloat($in);
		$mapWaterColor = LE::readSignedInt($in);
		$hasRain = CodecHelper::readBool($in);
		$tagIndexes = CodecHelper::readOptional($in, fn($i) => CodecHelper::readList($i, LE::readUnsignedShort(...)));
		$chunkGenData = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeDefinitionChunkGenData::class, $i));

		return new BiomeDefinitionData(
			nameIndex: $nameIndex,
			id: $id,
			temperature: $temperature,
			downfall: $downfall,
			foliageSnow: $foliageSnow,
			depth: $depth,
			scale: $scale,
			mapWaterColor: $mapWaterColor,
			hasRain: $hasRain,
			tagIndexes: $tagIndexes,
			chunkGenData: $chunkGenData
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeDefinitionData);

		LE::writeUnsignedShort($out, $data->nameIndex);
		LE::writeUnsignedShort($out, $data->id);
		LE::writeFloat($out, $data->temperature);
		LE::writeFloat($out, $data->downfall);
		LE::writeFloat($out, $data->foliageSnow);
		LE::writeFloat($out, $data->depth);
		LE::writeFloat($out, $data->scale);
		LE::writeSignedInt($out, $data->mapWaterColor);
		CodecHelper::writeBool($out, $data->hasRain);
		CodecHelper::writeOptional($out, $data->tagIndexes, fn($o, $v) => CodecHelper::writeList($o, $v, LE::writeUnsignedShort(...)));
		CodecHelper::writeOptional($out, $data->chunkGenData, fn($o, $v) => $codec->write(BiomeDefinitionChunkGenData::class, $o, $v));
	}
}
