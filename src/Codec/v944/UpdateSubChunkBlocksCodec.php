<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\SubChunk\UpdateSubChunkBlocksPacketEntry;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\UpdateSubChunkBlocksPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class UpdateSubChunkBlocksCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : UpdateSubChunkBlocksPacket{
        $pk = new UpdateSubChunkBlocksPacket();
        $pk->baseBlockPosition = CodecHelper::readSignedBlockPosition($in);
        $pk->layer0Updates = CodecHelper::readList($in, fn($i) => $codec->read(UpdateSubChunkBlocksPacketEntry::class, $i));
        $pk->layer1Updates = CodecHelper::readList($in, fn($i) => $codec->read(UpdateSubChunkBlocksPacketEntry::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof UpdateSubChunkBlocksPacket);
        CodecHelper::writeSignedBlockPosition($out, $pk->baseBlockPosition);
        CodecHelper::writeList($out, $pk->layer0Updates, fn($o, $v) => $codec->write(UpdateSubChunkBlocksPacketEntry::class, $o, $v));
        CodecHelper::writeList($out, $pk->layer1Updates, fn($o, $v) => $codec->write(UpdateSubChunkBlocksPacketEntry::class, $o, $v));
    }
}
