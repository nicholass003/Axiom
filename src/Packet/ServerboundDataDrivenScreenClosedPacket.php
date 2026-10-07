<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Enum\ScreenCloseReason;

class ServerboundDataDrivenScreenClosedPacket implements Packet{

    public const ID = PacketIds::SERVERBOUND_DATA_DRIVEN_SCREEN_CLOSED;
    public const RECIPIENT = PacketRecipient::SERVER;

    public int $formId = 0;
    public ScreenCloseReason $closeReason = ScreenCloseReason::CLIENT_CANCELED;
}
