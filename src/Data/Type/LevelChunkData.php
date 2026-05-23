<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type;

class LevelChunkData{

    /**
     * @param int[]|null $usedBlobHashes
     */
    public function __construct(
        public readonly ChunkPosition $position,
        public readonly int $dimensionId,
        public readonly int $subChunkCount,
        public readonly bool $clientSubChunkRequestsEnabled,
        public readonly ?array $usedBlobHashes,
        public readonly string $payload // RAW chunk data
    ){}
}
