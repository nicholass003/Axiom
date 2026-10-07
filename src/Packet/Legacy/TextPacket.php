<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet\Legacy;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Packet\Packet;

/** @since v41 */
class TextPacket implements Packet{

    public const ID = PacketIds::TEXT;
    public const RECIPIENT = PacketRecipient::BOTH;

	const TYPE_RAW = 0;
	const TYPE_CHAT = 1;
	const TYPE_TRANSLATION = 2;
	const TYPE_POPUP = 3;
	const TYPE_TIP = 4;
	const TYPE_SYSTEM = 5;

    public int $type;
    public string $source = '';
    public string $message = '';
    /** @var string[] */
    public array $parameters = [];
}
