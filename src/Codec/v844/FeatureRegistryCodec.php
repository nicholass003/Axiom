<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\FeatureRegistryPacketEntry;
use Nicholass003\Axiom\Packet\FeatureRegistryPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class FeatureRegistryCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : FeatureRegistryPacket{
        $pk = new FeatureRegistryPacket();
        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->read(FeatureRegistryPacketEntry::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof FeatureRegistryPacket);
        $codec->write(FeatureRegistryPacketEntry::class, $out, $pk->entries);
    }
}
