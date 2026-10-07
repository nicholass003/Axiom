<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Packet\MobEquipmentPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class MobEquipmentCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : MobEquipmentPacket{
        $pk = new MobEquipmentPacket();
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->item = $codec->read(ItemStackWrapper::class, $in);
        $pk->inventorySlot = Byte::readUnsigned($in);
        $pk->hotbarSlot = Byte::readUnsigned($in);
        $pk->windowId = Byte::readUnsigned($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof MobEquipmentPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        $codec->write(ItemStackWrapper::class, $out, $pk->item);
        Byte::writeUnsigned($out, $pk->inventorySlot);
        Byte::writeUnsigned($out, $pk->hotbarSlot);
        Byte::writeUnsigned($out, $pk->windowId);
    }
}
