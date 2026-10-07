<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum ScreenCloseReason : string{
    use OrdinalEnumTrait;

    case PROGRAMMATIC_CLOSE = "programmaticclose";
    case PROGRAMMATIC_CLOSE_ALL = "programmaticcloseall";
    case CLIENT_CANCELED = "clientcanceled";
    case USER_BUSY = "userbusy";
    case INVALID_FORM = "invalidform";
}
