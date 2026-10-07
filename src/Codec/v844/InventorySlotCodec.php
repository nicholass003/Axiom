<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Enum\ContainerIds;
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
        $pk->containerName = $codec->read(FullContainerName::class, $in);
        $pk->storage = $codec->read(ItemStackWrapper::class, $in);
        $pk->item = $codec->read(ItemStackWrapper::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof InventorySlotPacket);
        VarInt::writeUnsignedInt($out, $pk->windowId);
        VarInt::writeUnsignedInt($out, $pk->inventorySlot);
        $codec->write(FullContainerName::class, $out, $pk->containerName ?? new FullContainerName(ContainerIds::NONE->value));
        $codec->write(ItemStackWrapper::class, $out, $pk->storage ?? new ItemStackWrapper(0, new ItemStack(0, 0, 0, 0, '')));
        $codec->write(ItemStackWrapper::class, $out, $pk->item);
    }
}
