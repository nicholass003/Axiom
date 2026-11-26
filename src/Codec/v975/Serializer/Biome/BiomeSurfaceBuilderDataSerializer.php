<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCappedSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMesaSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeNoiseGradientSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceBuilderData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeSurfaceBuilderDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeSurfaceBuilderData{
		return new BiomeSurfaceBuilderData(
			surfaceMaterial: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceMaterialData::class, $i)),
			defaultOverworldSurface: CodecHelper::readBool($in),
			swampSurface: CodecHelper::readBool($in),
			frozenOceanSurface: CodecHelper::readBool($in),
			theEndSurface: CodecHelper::readBool($in),
			mesaSurface: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMesaSurfaceData::class, $i)),
			cappedSurface: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeCappedSurfaceData::class, $i)),
			noiseGradientSurface: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeNoiseGradientSurfaceData::class, $i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeSurfaceBuilderData);

		CodecHelper::writeOptional($out, $data->surfaceMaterial, fn($o, $v) => $codec->write(BiomeSurfaceMaterialData::class, $o, $v));
		CodecHelper::writeBool($out, $data->defaultOverworldSurface);
		CodecHelper::writeBool($out, $data->swampSurface);
		CodecHelper::writeBool($out, $data->frozenOceanSurface);
		CodecHelper::writeBool($out, $data->theEndSurface);
		CodecHelper::writeOptional($out, $data->mesaSurface, fn($o, $v) => $codec->write(BiomeMesaSurfaceData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->cappedSurface, fn($o, $v) => $codec->write(BiomeCappedSurfaceData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->noiseGradientSurface, fn($o, $v) => $codec->write(BiomeNoiseGradientSurfaceData::class, $o, $v));
	}
}
