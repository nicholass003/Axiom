<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceOptions;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceType;

/** @since v2193 */
class SetPlayerFurnaceOptionsPacket implements Packet{

    public const ID = PacketIds::SET_PLAYER_FURNACE_OPTIONS;
    public const RECIPIENT = PacketRecipient::SERVER;

    public FurnaceType $furnaceType;
    public FurnaceOptions $furnaceOptions;
}
