<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ItemTypeEntry;
use Nicholass003\Axiom\Packet\ItemRegistryPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ItemRegistryCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ItemRegistryPacket{
        $pk = new ItemRegistryPacket();
        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->read(ItemTypeEntry::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ItemRegistryPacket);
        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => $codec->write(ItemTypeEntry::class, $o, $v));
    }
}
