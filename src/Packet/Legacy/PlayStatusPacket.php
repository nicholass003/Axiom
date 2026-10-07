<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class PlayStatusPacket implements Packet{

    public const ID = PacketIds::PLAY_STATUS;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $status;
}
