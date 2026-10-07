<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketEntryCommon;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketEntryWithCache;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketEntryWithoutCache;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPosition;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SubChunkPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class SubChunkCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SubChunkPacket{
        $pk = new SubChunkPacket();
        $cacheEnabled = CodecHelper::readBool($in);
        $pk->cacheEnabled = $cacheEnabled;
        $pk->dimension = VarInt::readSignedInt($in);
        $pk->baseSubChunkPosition = $codec->read(SubChunkPosition::class, $in);

        $count = LE::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $common = $codec->get(SubChunkPacketEntryCommon::class)->read($in, $codec, $cacheEnabled);
            if($cacheEnabled){
                $hash = LE::readUnsignedLong($in);
                $pk->entries[] = new SubChunkPacketEntryWithCache($common, $hash);
            }else{
                $pk->entries[] = new SubChunkPacketEntryWithoutCache($common);
            }
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SubChunkPacket);
        CodecHelper::writeBool($out, $pk->cacheEnabled);
        VarInt::writeSignedInt($out, $pk->dimension);
        $codec->write(SubChunkPosition::class, $out, $pk->baseSubChunkPosition);

        LE::writeUnsignedInt($out, count($pk->entries));
        foreach($pk->entries as $entry){
            if($entry instanceof SubChunkPacketEntryWithCache){
                $codec->get(SubChunkPacketEntryCommon::class)->write($out, $entry->base, $codec, true);
                LE::writeUnsignedLong($out, $entry->usedBlobHash);
            }else{
                $codec->get(SubChunkPacketEntryCommon::class)->write($out, $entry->base, $codec, false);
            }
        }
    }
}
