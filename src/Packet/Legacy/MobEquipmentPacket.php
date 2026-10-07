<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class MobEquipmentPacket implements Packet{

    public const ID = PacketIds::MOB_EQUIPMENT;
    public const RECIPIENT = PacketRecipient::BOTH;

    public int $eid;
    public array $item;
    public int $slot;
    public int $selectedSlot;
}
