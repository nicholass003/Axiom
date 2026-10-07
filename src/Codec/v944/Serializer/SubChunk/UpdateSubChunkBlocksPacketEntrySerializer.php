<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\UpdateSubChunkBlocksPacketEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class UpdateSubChunkBlocksPacketEntrySerializer implements SerializerInterface{
	use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : UpdateSubChunkBlocksPacketEntry{
        return new UpdateSubChunkBlocksPacketEntry(
            blockPosition: CodecHelper::readSignedBlockPosition($in),
            blockRuntimeId: VarInt::readUnsignedInt($in),
            flags: VarInt::readUnsignedInt($in),
            syncedUpdateType: VarInt::readUnsignedInt($in),
            actorUniqueId: CodecHelper::readActorUniqueId($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof UpdateSubChunkBlocksPacketEntry);

        CodecHelper::writeSignedBlockPosition($out, $data->blockPosition);
        VarInt::writeUnsignedInt($out, $data->blockRuntimeId);
        VarInt::writeUnsignedInt($out, $data->flags);
        VarInt::writeUnsignedInt($out, $data->syncedUpdateType);
        CodecHelper::writeActorUniqueId($out, $data->actorUniqueId);
    }
}
