<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class ContainerSetSlotPacket implements Packet{

    public const ID = PacketIds::CONTAINER_SET_SLOT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $windowid;
    public int $slot;
    public int $hotbarSlot;
    public array $item;
}
