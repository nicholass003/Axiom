<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\LevelChunkPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class LevelChunkCodec implements Codec{

    private const MAX_BLOB_HASHES = 64;

    public function decode(ByteBufferReader $in, CodecType $codec) : LevelChunkPacket{
        $pk = new LevelChunkPacket();
        $pk->position = CodecHelper::readChunkPosition($in);
        $pk->dimensionId = VarInt::readSignedInt($in);

        $pk->subChunkCount = VarInt::readUnsignedInt($in);
        $pk->subChunkRequestLimit = CodecHelper::readOptional($in, VarInt::readSignedInt(...));

        $pk->cacheEnabled = CodecHelper::readBool($in);

        $pk->usedBlobHashes = [];
        $count = VarInt::readUnsignedInt($in);
        if($count > self::MAX_BLOB_HASHES){
            throw new \RuntimeException("Expected at most " . self::MAX_BLOB_HASHES . " blob hashes, got $count");
        }
        for($i = 0; $i < $count; $i++){
            $pk->usedBlobHashes[] = LE::readUnsignedLong($in);
        }

        $pk->payload = CodecHelper::readString($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof LevelChunkPacket);
        CodecHelper::writeChunkPosition($out, $pk->position);
        VarInt::writeSignedInt($out, $pk->dimensionId);

        VarInt::writeUnsignedInt($out, $pk->subChunkCount);
        CodecHelper::writeOptional($out, $pk->subChunkRequestLimit, VarInt::writeSignedInt(...));

        CodecHelper::writeBool($out, $pk->cacheEnabled);

        VarInt::writeUnsignedInt($out, count($pk->usedBlobHashes ?? []));
        foreach($pk->usedBlobHashes ?? [] as $hash){
            LE::writeUnsignedLong($out, $hash);
        }

        CodecHelper::writeString($out, $pk->payload);
    }
}
