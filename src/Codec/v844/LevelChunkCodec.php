<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\LevelChunkData;
use Nicholass003\Axiom\Packet\LevelChunkPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class LevelChunkCodec implements Codec{

    private const CLIENT_REQUEST_FULL_COLUMN_FAKE_COUNT = 0xFFFFFFFF;
    private const CLIENT_REQUEST_TRUNCATED_COLUMN_FAKE_COUNT = 0xFFFFFFFE;

    public function decode(ByteBufferReader $in, CodecType $codec) : LevelChunkPacket{
        $pk = new LevelChunkPacket();
        $position = CodecHelper::readChunkPosition($in);
        $dimensionId = VarInt::readSignedInt($in);
        $rawCount = VarInt::readUnsignedInt($in);
        $clientRequests = false;
        $subChunkCount = $rawCount;

        if($rawCount === self::CLIENT_REQUEST_FULL_COLUMN_FAKE_COUNT){
            $clientRequests = true;
            $subChunkCount = PHP_INT_MAX;

        }elseif($rawCount === self::CLIENT_REQUEST_TRUNCATED_COLUMN_FAKE_COUNT){
            $clientRequests = true;
            $subChunkCount = LE::readUnsignedShort($in);
        }

        $usedBlobHashes = null;

        $cacheEnabled = CodecHelper::readBool($in);
        if($cacheEnabled){
            $count = VarInt::readUnsignedInt($in);
            if($count > 64){
                throw new \RuntimeException("Too many blob hashes: $count");
            }

            $usedBlobHashes = [];

            for($i = 0; $i < $count; $i++){
                $usedBlobHashes[] = LE::readUnsignedLong($in);
            }
        }

        $payload = CodecHelper::readString($in);
        $pk->data = new LevelChunkData(
            $position,
            $dimensionId,
            $subChunkCount,
            $clientRequests,
            $usedBlobHashes,
            $payload
        );

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof LevelChunkPacket);
        $d = $pk->data;
        CodecHelper::writeChunkPosition($out, $d->position);
        VarInt::writeSignedInt($out, $d->dimensionId);

        if($d->clientSubChunkRequestsEnabled){
            if($d->subChunkCount === PHP_INT_MAX){
                VarInt::writeUnsignedInt($out, self::CLIENT_REQUEST_FULL_COLUMN_FAKE_COUNT);
            }else{
                VarInt::writeUnsignedInt($out, self::CLIENT_REQUEST_TRUNCATED_COLUMN_FAKE_COUNT);
                LE::writeUnsignedShort($out, $d->subChunkCount);
            }
        }else{
            VarInt::writeUnsignedInt($out, $d->subChunkCount);
        }

        CodecHelper::writeBool($out, $d->usedBlobHashes !== null);

        if($d->usedBlobHashes !== null){
            VarInt::writeUnsignedInt($out, count($d->usedBlobHashes));

            foreach($d->usedBlobHashes as $hash){
                LE::writeUnsignedLong($out, $hash);
            }
        }

        CodecHelper::writeString($out, $d->payload);
    }
}
