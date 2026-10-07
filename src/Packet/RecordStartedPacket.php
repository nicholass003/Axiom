<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\BlockPosition;

/** @since v2193 */
class RecordStartedPacket implements Packet{

    public const ID = PacketIds::RECORD_STARTED;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public BlockPosition $blockPosition;
    public int $serverSoundHandle;
}
