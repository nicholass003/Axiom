<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class CraftingDataPacket implements Packet{

    public const ID = PacketIds::CRAFTING_DATA;
    public const RECIPIENT = PacketRecipient::CLIENT;

    /** @var array[] */
    public array $entries = [];
    public bool $cleanRecipes = false;
}
