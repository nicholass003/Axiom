<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;

class MoveActorDeltaPacket implements Packet{

    public const ID = PacketIds::MOVE_ACTOR_DELTA;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $actorRuntimeId;
    public int $flags;

    public ?float $xPos = null;
    public ?float $yPos = null;
    public ?float $zPos = null;
    public ?float $pitch = null;
    public ?float $yaw = null;
    public ?float $headYaw = null;

    /** @since v2168 */
    public bool $onGround = false;
    /** @since v2168 */
    public bool $teleport = false;
    /** @since v2168 */
    public bool $forceMoveLocalEntity = false;
    /** @since v2168 */
    public bool $forceCompletion = false;
    /** @since v2193 */
    public int $ticks = 0;
}
