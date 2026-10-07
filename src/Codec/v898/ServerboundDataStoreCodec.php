<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ServerboundDataStorePacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ServerboundDataStoreCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ServerboundDataStorePacket{
        $pk = new ServerboundDataStorePacket();
        $pk->update = $codec->read(DataStoreUpdate::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ServerboundDataStorePacket);
        $codec->write(DataStoreUpdate::class, $out, $pk->update);
    }
}
