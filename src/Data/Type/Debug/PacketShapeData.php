<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Debug;

use Nicholass003\Axiom\Data\Type\Vec3;
use Nicholass003\Axiom\Enum\ScriptDebugShapeType;

class PacketShapeData{

    public function __construct(
        public readonly int $networkId,
        public readonly ?ScriptDebugShapeType $type,
        public readonly ?Vec3 $location,
        public readonly ?float $scale,
        public readonly ?Vec3 $rotation,
        public readonly ?float $totalTimeLeft,
        /** @since v975 */
        public readonly ?float $maximumRenderDistance,
        public readonly ?int $colorArgb,
        public readonly ?string $text,
        /** @since v975 */
        public readonly ?bool $useRotation,
        /** @since v975 */
        public readonly ?int $backgroundColorArgb,
        /** @since v975 */
        public readonly ?bool $depthTest,
        /** @since v975 */
        public readonly ?bool $showBackface,
        /** @since v975 */
        public readonly ?bool $showTextBackface,
        public readonly ?Vec3 $boxBound,
        public readonly ?Vec3 $lineEndLocation,
        public readonly ?float $arrowHeadLength,
        public readonly ?float $arrowHeadRadius,
        public readonly ?int $segments,
        /** Optional since v924; required in earlier protocols. */
        public readonly ?int $dimensionId = null,
        /** @since v924 */
        public readonly ?int $attachedToEntityId = null,
    ){}
}
