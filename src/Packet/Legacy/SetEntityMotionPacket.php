<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class SetEntityMotionPacket implements Packet{

    public const ID = PacketIds::SET_ENTITY_MOTION;
    public const RECIPIENT = PacketRecipient::CLIENT;

    /** @var array[] each: [eid, motX, motY, motZ] */
    public array $entities = [];
}
