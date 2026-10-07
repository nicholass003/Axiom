<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Enum;

enum ScorePacketEntryType : string{
    use OrdinalEnumTrait;

	case REMOVE = "remove";
	case CHANGE_PLAYER = "changeplayer";
	case CHANGE_ENTITY = "changeentity";
	case CHANGE_FAKE_PLAYER = "changefakeplayer";
}
