<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class InteractPacket implements Packet{

    public const ID = PacketIds::INTERACT;
    public const RECIPIENT = PacketRecipient::SERVER;

    public int $action;
    public int $target;
}
