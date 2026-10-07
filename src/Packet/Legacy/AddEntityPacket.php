<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class AddEntityPacket implements Packet{

    public const ID = PacketIds::ADD_ENTITY;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public int $type;
    public float $x;
    public float $y;
    public float $z;
    public float $speedX;
    public float $speedY;
    public float $speedZ;
    public float $yaw;
    public float $pitch;
    public string $metadata;
    /** @var array[] */
    public array $links = [];
}
