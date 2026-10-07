<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeGroupEntry;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeItemEntry;
use Nicholass003\Axiom\Packet\CreativeContentPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CreativeContentCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CreativeContentPacket{
        $pk = new CreativeContentPacket();
        $pk->groups = CodecHelper::readList($in, fn($i) => $codec->read(CreativeGroupEntry::class, $i));
        $pk->items = CodecHelper::readList($in, fn($i) => $codec->read(CreativeItemEntry::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CreativeContentPacket);
        CodecHelper::writeList($out, $pk->groups, fn($o, $v) => $codec->write(CreativeGroupEntry::class, $o, $v));
        CodecHelper::writeList($out, $pk->items, fn($o, $v) => $codec->write(CreativeItemEntry::class, $o, $v));
    }
}
