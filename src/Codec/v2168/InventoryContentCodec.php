<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Packet\InventoryContentPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class InventoryContentCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : InventoryContentPacket{
        $pk = new InventoryContentPacket();
        $pk->windowId = VarInt::readUnsignedInt($in);
        $pk->items = CodecHelper::readList($in, fn($i) => $codec->read(ItemStackWrapper::class, $i));
        $pk->containerName = $codec->read(FullContainerName::class, $in);
        $pk->storage = $codec->read(ItemStackWrapper::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof InventoryContentPacket);
        VarInt::writeUnsignedInt($out, $pk->windowId);
        CodecHelper::writeList($out, $pk->items, fn($o, $v) => $codec->write(ItemStackWrapper::class, $o, $v));
        $codec->write(FullContainerName::class, $out, $pk->containerName);
        $codec->write(ItemStackWrapper::class, $out, $pk->storage);
    }
}
