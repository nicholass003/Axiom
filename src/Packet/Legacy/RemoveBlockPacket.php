<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class RemoveBlockPacket implements Packet{

    public const ID = PacketIds::REMOVE_BLOCK;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public int $x;
    public int $z;
    public int $y;
}
