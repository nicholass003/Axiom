<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class RemovePlayerPacket implements Packet{

    public const ID = PacketIds::REMOVE_PLAYER;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $eid;
    public string $clientId;
}
