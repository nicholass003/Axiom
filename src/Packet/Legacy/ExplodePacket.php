<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class ExplodePacket implements Packet{

    public const ID = PacketIds::EXPLODE;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public float $x;
    public float $y;
    public float $z;
    public float $radius;
    /** @var object[] */
    public array $records = [];
}
