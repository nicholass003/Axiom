<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class HurtArmorPacket implements Packet{

    public const ID = PacketIds::HURT_ARMOR;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $health;
}
