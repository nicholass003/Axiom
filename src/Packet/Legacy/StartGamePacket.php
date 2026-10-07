<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class StartGamePacket implements Packet{

    public const ID = PacketIds::START_GAME;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $seed;
    public int $dimension;
    public int $generator;
    public int $gamemode;
    public int $eid;
    public int $spawnX;
    public int $spawnY;
    public int $spawnZ;
    public float $x;
    public float $y;
    public float $z;
}
