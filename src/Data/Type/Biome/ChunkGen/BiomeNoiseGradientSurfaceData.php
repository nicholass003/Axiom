<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Biome\ChunkGen;

/** @since v975 */
class BiomeNoiseGradientSurfaceData{

    /**
     * @param list<int>   $nonReplaceableBlocks
     * @param list<int>   $gradientBlocks
     * @param list<float> $amplitudes
     */
    public function __construct(
        public readonly array $nonReplaceableBlocks,
        public readonly array $gradientBlocks,
        public readonly string $noiseSeed,
        public readonly int $firstOctave,
        public readonly array $amplitudes
    ){}
}
