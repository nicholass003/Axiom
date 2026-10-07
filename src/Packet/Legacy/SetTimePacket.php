<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class SetTimePacket implements Packet{

    public const ID = PacketIds::SET_TIME;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $time;
    public bool $started = true;
}
