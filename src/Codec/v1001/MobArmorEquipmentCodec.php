<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v1001;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Packet\MobArmorEquipmentPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class MobArmorEquipmentCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : MobArmorEquipmentPacket{
        $pk = new MobArmorEquipmentPacket();
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->head = $codec->read(ItemStackWrapper::class, $in);
        $pk->chest = $codec->read(ItemStackWrapper::class, $in);
        $pk->legs = $codec->read(ItemStackWrapper::class, $in);
        $pk->feet = $codec->read(ItemStackWrapper::class, $in);
        $pk->body = $codec->read(ItemStackWrapper::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof MobArmorEquipmentPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        $codec->write(ItemStackWrapper::class, $out, $pk->head);
        $codec->write(ItemStackWrapper::class, $out, $pk->chest);
        $codec->write(ItemStackWrapper::class, $out, $pk->legs);
        $codec->write(ItemStackWrapper::class, $out, $pk->feet);
        $codec->write(ItemStackWrapper::class, $out, $pk->body);
    }
}
