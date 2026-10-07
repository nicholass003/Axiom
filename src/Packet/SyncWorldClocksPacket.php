<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksPayload;

class SyncWorldClocksPacket implements Packet{

    public const ID = PacketIds::SYNC_WORLD_CLOCKS;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public SyncWorldClocksPayload $payload;
}
