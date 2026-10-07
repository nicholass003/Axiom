<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class LoginPacket implements Packet{

    public const ID = PacketIds::LOGIN;
    public const RECIPIENT = PacketRecipient::SERVER;

    public string $username;
    public int $protocol1;
    public int $protocol2;
    public int $clientId;
    public string $clientUUID;
    public string $serverAddress;
    public string $clientSecret;
    public string $skinName;
    public string $skin;
}
