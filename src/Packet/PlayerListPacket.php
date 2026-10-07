<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\PlayerListEntry;
use Nicholass003\Axiom\Enum\PlayerListType;

class PlayerListPacket implements Packet{

    public const ID = PacketIds::PLAYER_LIST;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public PlayerListType $type;

    /** @var PlayerListEntry[] */
    public array $entries = [];
}
