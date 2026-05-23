<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

use Nicholass003\Axiom\Enum\MemoryCategory;

class MemoryCategoryCounter{

    public function __construct(
        public readonly MemoryCategory $category,
        public readonly int $bytes
    ){}
}
