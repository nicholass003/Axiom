<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class RespawnPacket implements Packet{

    public const ID = PacketIds::RESPAWN;
    public const RECIPIENT = PacketRecipient::BOTH;

    public float $x;
    public float $y;
    public float $z;
}
