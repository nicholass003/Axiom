<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeClimateData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeaturesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeLegacyWorldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMountainParamsData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMultinoiseGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeOverworldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceBuilderData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialAdjustmentData;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeDefinitionChunkGenDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeDefinitionChunkGenData{
		$climate = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeClimateData::class, $i));
		$consolidatedFeatures = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeConsolidatedFeaturesData::class, $i));
		$mountainParams = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMountainParamsData::class, $i));
		$surfaceMaterialAdjustment = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceMaterialAdjustmentData::class, $i));
		$overworldGenRules = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeOverworldGenRulesData::class, $i));
		$multinoiseGenRules = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeMultinoiseGenRulesData::class, $i));
		$legacyWorldGenRules = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeLegacyWorldGenRulesData::class, $i));
		$replacementsData = CodecHelper::readOptional($in, fn($i) => CodecHelper::readList($i, fn($j) => $codec->read(BiomeReplacementData::class, $j)));
		$villageType = CodecHelper::readOptional($in, fn($i) => Byte::readUnsigned($i));
		$surfaceBuilderData = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceBuilderData::class, $i));
		$subSurfaceBuilderData = CodecHelper::readOptional($in, fn($i) => $codec->read(BiomeSurfaceBuilderData::class, $i));

		return new BiomeDefinitionChunkGenData(
			climate: $climate,
			consolidatedFeatures: $consolidatedFeatures,
			mountainParams: $mountainParams,
			surfaceMaterialAdjustment: $surfaceMaterialAdjustment,
			surfaceMaterial: null,
			defaultOverworldSurface: false,
			swampSurface: false,
			frozenOceanSurface: false,
			theEndSurface: false,
			mesaSurface: null,
			cappedSurface: null,
			overworldGenRules: $overworldGenRules,
			multinoiseGenRules: $multinoiseGenRules,
			legacyWorldGenRules: $legacyWorldGenRules,
			replacementsData: $replacementsData,
			villageType: $villageType,
			surfaceBuilderData: $surfaceBuilderData,
			subSurfaceBuilderData: $subSurfaceBuilderData
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeDefinitionChunkGenData);

		CodecHelper::writeOptional($out, $data->climate, fn($o, $v) => $codec->write(BiomeClimateData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->consolidatedFeatures, fn($o, $v) => $codec->write(BiomeConsolidatedFeaturesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->mountainParams, fn($o, $v) => $codec->write(BiomeMountainParamsData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->surfaceMaterialAdjustment, fn($o, $v) => $codec->write(BiomeSurfaceMaterialAdjustmentData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->overworldGenRules, fn($o, $v) => $codec->write(BiomeOverworldGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->multinoiseGenRules, fn($o, $v) => $codec->write(BiomeMultinoiseGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->legacyWorldGenRules, fn($o, $v) => $codec->write(BiomeLegacyWorldGenRulesData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->replacementsData, fn($o, $v) => CodecHelper::writeList($o, $v, fn($o2, $e) => $codec->write(BiomeReplacementData::class, $o2, $e)));
		CodecHelper::writeOptional($out, $data->villageType, fn($o, $v) => Byte::writeUnsigned($o, $v));
		CodecHelper::writeOptional($out, $data->surfaceBuilderData, fn($o, $v) => $codec->write(BiomeSurfaceBuilderData::class, $o, $v));
		CodecHelper::writeOptional($out, $data->subSurfaceBuilderData, fn($o, $v) => $codec->write(BiomeSurfaceBuilderData::class, $o, $v));
	}
}
