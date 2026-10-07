<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class AddItemEntityPacket implements Packet{

    public const ID = PacketIds::ADD_ITEM_ENTITY;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public array $item;
    public float $x;
    public float $y;
    public float $z;
    public float $speedX;
    public float $speedY;
    public float $speedZ;
}
