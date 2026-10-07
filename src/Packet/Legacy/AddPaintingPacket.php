<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class AddPaintingPacket implements Packet{

    public const ID = PacketIds::ADD_PAINTING;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public int $x;
    public int $y;
    public int $z;
    public int $direction;
    public string $title;
}
