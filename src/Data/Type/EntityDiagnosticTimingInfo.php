<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

/** @since v975 */
class EntityDiagnosticTimingInfo{

    /** @since v2193 */
    public readonly Vec3 $position;
    /** @since v2193 */
    public readonly string $dimension;

    public function __construct(
        public readonly string $displayName,
        public readonly string $entity,
        public readonly int $timeInNS,
        public readonly int $percentOfTotal,
        Vec3 $position = new Vec3(0, 0, 0),
        string $dimension = ''
    ){
        $this->position = $position;
        $this->dimension = $dimension;
    }
}
