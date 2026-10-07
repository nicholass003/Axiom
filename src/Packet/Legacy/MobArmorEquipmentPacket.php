<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class MobArmorEquipmentPacket implements Packet{

    public const ID = PacketIds::MOB_ARMOR_EQUIPMENT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    /** @var array[] 4 slots */
    public array $slots = [];
}
