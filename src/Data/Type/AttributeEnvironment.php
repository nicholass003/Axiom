<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class AttributeEnvironment{

    /** @since v2193 */
    public readonly ?NoiseAlignment $noiseAlignment;

    public function __construct(
        public readonly string $name,
        public readonly ?AttributeValue $fromAttribute,
        public readonly AttributeValue $attribute,
        public readonly ?AttributeValue $toAttribute,
        public readonly int $currentTransitionTicks,
        public readonly int $totalTransitionTicks,
        public readonly string $easeType,
        /** @since v1001 */
        public readonly int $localTransitionTicks = 0,
        /** @since v1001 */
        public readonly bool $noiseTransition = false,
        ?NoiseAlignment $noiseAlignment = null,
    ){
        $this->noiseAlignment = $noiseAlignment;
    }
}
