<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v1001;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPosition;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SubChunkRequestPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SubChunkRequestCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SubChunkRequestPacket{
        $pk = new SubChunkRequestPacket();
        $pk->dimension = VarInt::readSignedInt($in);

        $count = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $pk->entries[] = CodecHelper::readSubChunkOffset($in);
        }

        $pk->basePosition = $codec->get(SubChunkPosition::class)->read($in, $codec, true);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SubChunkRequestPacket);
        VarInt::writeSignedInt($out, $pk->dimension);

        VarInt::writeUnsignedInt($out, count($pk->entries));
        foreach($pk->entries as $entry){
            CodecHelper::writeSubChunkOffset($out, $entry);
        }

        $codec->get(SubChunkPosition::class)->write($out, $pk->basePosition, $codec, true);
    }
}
