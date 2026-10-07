<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class AddPlayerPacket implements Packet{

    public const ID = PacketIds::ADD_PLAYER;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public string $uuid;
    public string $username;
    public int $eid;
    public float $x;
    public float $y;
    public float $z;
    public float $speedX;
    public float $speedY;
    public float $speedZ;
    public float $pitch;
    public float $yaw;
    public array $item;
    public string $metadata;
}
