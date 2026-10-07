<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum SyncWorldClocksType : int{

    case SYNC_STATE = 0;
    case INITIALIZE_REGISTRY = 1;
    case ADD_TIME_MARKER = 2;
    case REMOVE_TIME_MARKER = 3;
}
