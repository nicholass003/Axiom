<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\DataStore;

use Nicholass003\Axiom\Enum\DataStoreType;

abstract class DataStore{

    public function __construct(
        public readonly DataStoreType $type
    ){}
}
