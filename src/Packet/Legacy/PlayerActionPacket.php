<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class PlayerActionPacket implements Packet{

    public const ID = PacketIds::PLAYER_ACTION;
    public const RECIPIENT = PacketRecipient::SERVER;

    public int $eid;
    public int $action;
    public int $x;
    public int $y;
    public int $z;
    public int $face;
}
