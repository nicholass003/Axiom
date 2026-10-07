<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class MobEffectPacket implements Packet{

    public const ID = PacketIds::MOB_EFFECT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public int $eventId;
    public int $effectId;
    public int $amplifier;
    public bool $particles;
    public int $duration;
}
