<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class MovePlayerPacket implements Packet{

    public const ID = PacketIds::MOVE_PLAYER;
    public const RECIPIENT = PacketRecipient::BOTH;

    public int $eid;
    public float $x;
    public float $y;
    public float $z;
    public float $yaw;
    public float $bodyYaw;
    public float $pitch;
    public int $mode;
    public bool $onGround;
}
