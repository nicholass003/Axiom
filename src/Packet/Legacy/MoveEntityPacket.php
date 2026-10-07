<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class MoveEntityPacket implements Packet{

    public const ID = PacketIds::MOVE_ENTITY;
    public const RECIPIENT = PacketRecipient::CLIENT;

    /** @var array[] each: [eid, x, y, z, yaw, headYaw, pitch] */
    public array $entities = [];
}
