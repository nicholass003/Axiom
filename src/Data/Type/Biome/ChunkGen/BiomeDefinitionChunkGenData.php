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
    /** 
     * @since v975
     * @var BiomeSurfaceBuilderData|null $surfaceBuilderData
     */
    public readonly ?BiomeSurfaceBuilderData $surfaceBuilderData;
    /** 
     * @since v975
     * @var BiomeSurfaceBuilderData|null $subSurfaceBuilderData
     */
    public readonly ?BiomeSurfaceBuilderData $subSurfaceBuilderData;

    public function __construct(
        public readonly ?BiomeClimateData $climate,
        public readonly ?BiomeConsolidatedFeaturesData $consolidatedFeatures,
        public readonly ?BiomeMountainParamsData $mountainParams,
        public readonly ?BiomeSurfaceMaterialAdjustmentData $surfaceMaterialAdjustment,
        /** @deprecated v975 */
        public readonly ?BiomeSurfaceMaterialData $surfaceMaterial,
        /** @deprecated v975 */
        public readonly bool $defaultOverworldSurface,
        /** @deprecated v975 */
        public readonly bool $swampSurface,
        /** @deprecated v975 */
        public readonly bool $frozenOceanSurface,
        /** @deprecated v975 */
        public readonly bool $theEndSurface,
        /** @deprecated v975 */
        public readonly ?BiomeMesaSurfaceData $mesaSurface,
        /** @deprecated v975 */
        public readonly ?BiomeCappedSurfaceData $cappedSurface,
        public readonly ?BiomeOverworldGenRulesData $overworldGenRules,
        public readonly ?BiomeMultinoiseGenRulesData $multinoiseGenRules,
        public readonly ?BiomeLegacyWorldGenRulesData $legacyWorldGenRules,
        ?array $replacementsData = null,
        ?int $villageType = null,
        ?BiomeSurfaceBuilderData $surfaceBuilderData = null,
        ?BiomeSurfaceBuilderData $subSurfaceBuilderData = null
    ){
        $this->replacementsData = $replacementsData;
        $this->villageType = $villageType;
        $this->surfaceBuilderData = $surfaceBuilderData;
        $this->subSurfaceBuilderData = $subSurfaceBuilderData;
    }
}
