<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\AttributesRemoveEnvironment;
use Nicholass003\Axiom\Data\Type\AttributesUpdateEnvironment;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayers;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayerSettings;
use Nicholass003\Axiom\Enum\AttributeLayerSyncType;
use Nicholass003\Axiom\Packet\ClientboundAttributeLayerSyncPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ClientboundAttributeLayerSyncCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientboundAttributeLayerSyncPacket{
        $pk = new ClientboundAttributeLayerSyncPacket();
        $typeId = VarInt::readUnsignedInt($in);
        $pk->payload = match($typeId){
            AttributeLayerSyncType::UPDATE_LAYERS => $codec->read(AttributeUpdateLayers::class, $in),
            AttributeLayerSyncType::UPDATE_LAYER_SETTINGS => $codec->read(AttributeUpdateLayerSettings::class, $in),
            AttributeLayerSyncType::UPDATE_ENVIRONMENT => $codec->read(AttributesUpdateEnvironment::class, $in),
            AttributeLayerSyncType::REMOVE_ENVIRONMENT => $codec->read(AttributesRemoveEnvironment::class, $in),
            default => throw new \RuntimeException("Unknown ClientboundAttributeLayerSync type: $typeId"),
        };
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundAttributeLayerSyncPacket);
        VarInt::writeUnsignedInt($out, $pk->payload->type->value);
        match(true){
            $pk->payload instanceof AttributeUpdateLayers => $codec->write(AttributeUpdateLayers::class, $out, $pk->payload),
            $pk->payload instanceof AttributeUpdateLayerSettings => $codec->write(AttributeUpdateLayerSettings::class, $out, $pk->payload),
            $pk->payload instanceof AttributesUpdateEnvironment => $codec->write(AttributesUpdateEnvironment::class, $out, $pk->payload),
            $pk->payload instanceof AttributesRemoveEnvironment => $codec->write(AttributesRemoveEnvironment::class, $out, $pk->payload),
            default => throw new \RuntimeException("Unknown ClientboundAttributeLayerSync payload type"),
        };
    }
}
