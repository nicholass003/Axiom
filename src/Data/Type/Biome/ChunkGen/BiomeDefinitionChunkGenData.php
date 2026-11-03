<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Biome\ChunkGen;

use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;

class BiomeDefinitionChunkGenData{

    /** 
     * @since v859
     * @var list<BiomeReplacementData>|null $replacementsData
     */
    public readonly ?array $replacementsData;
    /** 
     * @since v924
     * @var int|null $villageType
     */
    public readonly ?int $villageType;

    public function __construct(
        public readonly ?BiomeClimateData $climate,
        public readonly ?BiomeConsolidatedFeaturesData $consolidatedFeatures,
        public readonly ?BiomeMountainParamsData $mountainParams,
        public readonly ?BiomeSurfaceMaterialAdjustmentData $surfaceMaterialAdjustment,
        public readonly ?BiomeSurfaceMaterialData $surfaceMaterial,
        public readonly bool $defaultOverworldSurface,
        public readonly bool $swampSurface,
        public readonly bool $frozenOceanSurface,
        public readonly bool $theEndSurface,
        public readonly ?BiomeMesaSurfaceData $mesaSurface,
        public readonly ?BiomeCappedSurfaceData $cappedSurface,
        public readonly ?BiomeOverworldGenRulesData $overworldGenRules,
        public readonly ?BiomeMultinoiseGenRulesData $multinoiseGenRules,
        public readonly ?BiomeLegacyWorldGenRulesData $legacyWorldGenRules,
        ?array $replacementsData = null,
        ?int $villageType = null,
    ){
        $this->replacementsData = $replacementsData;
        $this->villageType = $villageType;
    }
}
