<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Biome\ChunkGen;

/** @since v975 */
class BiomeSurfaceBuilderData{

    public function __construct(
        public readonly ?BiomeSurfaceMaterialData $surfaceMaterial,
        public readonly bool $defaultOverworldSurface,
        public readonly bool $swampSurface,
        public readonly bool $frozenOceanSurface,
        public readonly bool $theEndSurface,
        public readonly ?BiomeMesaSurfaceData $mesaSurface,
        public readonly ?BiomeCappedSurfaceData $cappedSurface,
        public readonly ?BiomeNoiseGradientSurfaceData $noiseGradientSurface
    ){}
}
