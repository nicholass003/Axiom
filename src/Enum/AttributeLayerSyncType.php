<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum AttributeLayerSyncType : int{

    case UPDATE_LAYERS = 0;
    case UPDATE_LAYER_SETTINGS = 1;
    case UPDATE_ENVIRONMENT = 2;
    case REMOVE_ENVIRONMENT = 3;
}
