<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\LevelChunkData;

class LevelChunkPacket implements Packet{

    public const ID = PacketIds::LEVEL_CHUNK;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public LevelChunkData $data;
}
