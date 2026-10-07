<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

final class SystemCategory{

    public function __construct(
        public readonly string $categoryName,
        public readonly int $systemIndex
    ){}
}
