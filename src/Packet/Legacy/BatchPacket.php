<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class BatchPacket implements Packet{

    public const ID = PacketIds::BATCH;
    public const RECIPIENT = PacketRecipient::BOTH;

    /** @var Packet[] */
    public array $packets = [];
}
