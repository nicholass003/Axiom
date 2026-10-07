<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class AnimatePacket implements Packet{

    public const ID = PacketIds::ANIMATE;
    public const RECIPIENT = PacketRecipient::BOTH;

    public int $action;
    public int $eid;
}
