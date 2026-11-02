<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v859\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCappedSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeClimateData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeaturesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeLegacyWorldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMesaSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMountainParamsData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMultinoiseGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeOverworldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialAdjustmentData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeDefinitionChunkGenDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeDefinitionChunkGenData{
		return new BiomeDefinitionChunkGenData(
			climate: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeClimateData::class, $i)),
			consolidatedFeatures: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeConsolidatedFeaturesData::class, $i)),
			mountainParams: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMountainParamsData::class, $i)),
			surfaceMaterialAdjustment: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceMaterialAdjustmentData::class, $i)),
			surfaceMaterial: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceMaterialData::class, $i)),
			defaultOverworldSurface: CodecHelper::readBool($in),
			swampSurface: CodecHelper::readBool($in),
			frozenOceanSurface: CodecHelper::readBool($in),
			theEndSurface: CodecHelper::readBool($in),
			mesaSurface: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMesaSurfaceData::class, $i)),
			cappedSurface: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeCappedSurfaceData::class, $i)),
			overworldGenRules: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeOverworldGenRulesData::class, $i)),
			multinoiseGenRules: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMultinoiseGenRulesData::class, $i)),
			legacyWorldGenRules: CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeLegacyWorldGenRulesData::class, $i)),
			replacementsData: CodecHelper::readOptional($in, fn($i) => CodecHelper::readList($i, fn($j) => $codec->read(BiomeReplacementData::class, $j)))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeDefinitionChunkGenData);

		CodecHelper::writeOptional($out, $data->climate, fn($o, $v) => $codec->write(BiomeClimateData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->consolidatedFeatures, fn($o, $v) => $codec->write(BiomeConsolidatedFeaturesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->mountainParams, fn($o, $v) => $codec->write(BiomeMountainParamsData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->surfaceMaterialAdjustment, fn($o, $v) => $codec->write(BiomeSurfaceMaterialAdjustmentData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->surfaceMaterial, fn($o, $v) => $codec->write(BiomeSurfaceMaterialData::class, $o, $v));
		CodecHelper::writeBool($out, $data->defaultOverworldSurface);
		CodecHelper::writeBool($out, $data->swampSurface);
		CodecHelper::writeBool($out, $data->frozenOceanSurface);
		CodecHelper::writeBool($out, $data->theEndSurface);
		CodecHelper::writeOptional($out, $data->mesaSurface, fn($o, $v) => $codec->write(BiomeMesaSurfaceData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->cappedSurface, fn($o, $v) => $codec->write(BiomeCappedSurfaceData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->overworldGenRules, fn($o, $v) => $codec->write(BiomeOverworldGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->multinoiseGenRules, fn($o, $v) => $codec->write(BiomeMultinoiseGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->legacyWorldGenRules, fn($o, $v) => $codec->write(BiomeLegacyWorldGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->replacementsData, fn($o, $v) => CodecHelper::writeList($o, $v, fn($o2, $e) => $codec->write(BiomeReplacementData::class, $o2, $e)));
	}
}
