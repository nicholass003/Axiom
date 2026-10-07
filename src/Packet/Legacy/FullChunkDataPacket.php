<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class FullChunkDataPacket implements Packet{

    public const ID = PacketIds::FULL_CHUNK_DATA;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $chunkX;
    public int $chunkZ;
    public int $order = 0;
    public string $data;
}
