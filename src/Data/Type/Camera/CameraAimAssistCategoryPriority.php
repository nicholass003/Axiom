<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\Camera;

final class CameraAimAssistCategoryPriority{

    public function __construct(
        public readonly string $identifier,
        public readonly int $priority
    ){}
}
