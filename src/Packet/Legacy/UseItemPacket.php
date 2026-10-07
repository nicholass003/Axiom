<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class UseItemPacket implements Packet{

    public const ID = PacketIds::USE_ITEM;
    public const RECIPIENT = PacketRecipient::SERVER;

    public int $x;
    public int $y;
    public int $z;
    public int $face;
    public float $fx;
    public float $fy;
    public float $fz;
    public float $posX;
    public float $posY;
    public float $posZ;
    public array $item;
}
