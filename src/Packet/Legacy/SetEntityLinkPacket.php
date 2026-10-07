<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class SetEntityLinkPacket implements Packet{

    public const ID = PacketIds::SET_ENTITY_LINK;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $from;
    public int $to;
    public int $type;
}
