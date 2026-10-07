<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class ContainerSetContentPacket implements Packet{

    public const ID = PacketIds::CONTAINER_SET_CONTENT;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $windowid;
    /** @var array[] */
    public array $slots = [];
    /** @var int[] */
    public array $hotbar = [];
}
