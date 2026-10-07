<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

final class DimensionData{

    /** @since v2193 */
    public readonly int $dimensionType;
    /** @since v2193 */
    public readonly string $packId;
    /** @since v2193 */
    public readonly string $defaultBiome;

    public function __construct(
        public readonly int $maxHeight,
        public readonly int $minHeight,
        public readonly int $generator,
        int $dimensionType = 0,
        string $packId = '',
        string $defaultBiome = ''
    ){
        $this->dimensionType = $dimensionType;
        $this->packId = $packId;
        $this->defaultBiome = $defaultBiome;
    }
}
