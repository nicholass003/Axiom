<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ChunkCacheBlob;
use Nicholass003\Axiom\Packet\ClientCacheMissResponsePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ClientCacheMissResponseCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientCacheMissResponsePacket{
        $pk = new ClientCacheMissResponsePacket();
        $pk->blobs = CodecHelper::readList($in, fn($i) => $codec->read(ChunkCacheBlob::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientCacheMissResponsePacket);

        CodecHelper::writeList($out, $pk->blobs, fn($o, $v) => $codec->write(ChunkCacheBlob::class, $o, $v));
    }
}
