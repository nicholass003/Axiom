<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\ChunkPosition;

class LevelChunkPacket implements Packet{

    public const ID = PacketIds::LEVEL_CHUNK;
    public const RECIPIENT = PacketRecipient::CLIENT;

	public ChunkPosition $position;
	public int $dimensionId;
	public int $subChunkCount;
	public bool $clientSubChunkRequestsEnabled;

	// v2168: New field replaces clientSubChunkRequestsEnabled logic
	/** @since v2168 */
	public ?int $subChunkRequestLimit = null;

	public ?array $usedBlobHashes = null;
	// v2168: New field, cacheEnabled is now separate from usedBlobHashes
	/** @since v2168 */
	public bool $cacheEnabled = false;

	public string $payload;
}
