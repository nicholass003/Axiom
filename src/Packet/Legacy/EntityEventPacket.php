<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class EntityEventPacket implements Packet{

    public const ID = PacketIds::ENTITY_EVENT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public int $event;
}
