<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class BlockEventPacket implements Packet{

    public const ID = PacketIds::BLOCK_EVENT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $x;
    public int $y;
    public int $z;
    public int $case1;
    public int $case2;
}
