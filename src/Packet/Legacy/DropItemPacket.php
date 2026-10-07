<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class DropItemPacket implements Packet{

    public const ID = PacketIds::DROP_ITEM;
    public const RECIPIENT = PacketRecipient::SERVER;

    public int $type;
    public array $item;
}
