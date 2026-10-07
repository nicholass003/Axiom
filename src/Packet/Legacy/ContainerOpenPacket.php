<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class ContainerOpenPacket implements Packet{

    public const ID = PacketIds::CONTAINER_OPEN;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $windowid;
    public int $type;
    public int $slots;
    public int $x;
    public int $y;
    public int $z;
}
