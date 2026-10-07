<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum PlayerListType : int{
    use OrdinalEnumTrait;

    case ADD = 1;
    case REMOVE = 0;
}
