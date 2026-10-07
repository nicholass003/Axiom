<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class LevelEventPacket implements Packet{

    public const ID = PacketIds::LEVEL_EVENT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $evid;
    public float $x;
    public float $y;
    public float $z;
    public int $data;
}
