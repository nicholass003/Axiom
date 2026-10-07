<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class UpdateBlockPacket implements Packet{

    public const ID = PacketIds::UPDATE_BLOCK;
    public const RECIPIENT = PacketRecipient::CLIENT;

    /** @var array[] each: [x, z, y, blockId, blockData, flags] */
    public array $records = [];
}
