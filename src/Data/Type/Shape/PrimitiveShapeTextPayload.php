<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Shape;

use Nicholass003\Axiom\Codec\Common\Color;

class PrimitiveShapeTextPayload{

    public function __construct(
        public readonly string $text,
        public readonly bool $useRotation,
        /** @since v2193 */
        public readonly ?Color $backgroundColor,
        /** @since v2193 */
        public readonly float $lineGapHeight,
        public readonly bool $depthTest,
        public readonly bool $showBackface,
        public readonly bool $showTextBackface
    ){}
}