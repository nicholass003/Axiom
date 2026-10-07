<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Packet\InventorySlotPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class InventorySlotCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : InventorySlotPacket{
        $pk = new InventorySlotPacket();
        $pk->windowId = VarInt::readUnsignedInt($in);
        $pk->inventorySlot = VarInt::readUnsignedInt($in);
        $pk->containerName = CodecHelper::readOptional($in, fn($i) => $codec->read(FullContainerName::class, $i));
        $pk->storage = CodecHelper::readOptional($in, fn($i) => $codec->read(ItemStackWrapper::class, $i));
        $pk->item = $codec->read(ItemStackWrapper::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof InventorySlotPacket);
        VarInt::writeUnsignedInt($out, $pk->windowId);
        VarInt::writeUnsignedInt($out, $pk->inventorySlot);
        CodecHelper::writeOptional($out, $pk->containerName, fn($o, $v) => $codec->write(FullContainerName::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->storage, fn($o, $v) => $codec->write(ItemStackWrapper::class, $o, $v));
        $codec->write(ItemStackWrapper::class, $out, $pk->item);
    }
}
