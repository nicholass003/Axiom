<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\AbilitiesData;
use Nicholass003\Axiom\Data\Type\AbilitiesLayer;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\UpdateAbilitiesPacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class UpdateAbilitiesCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : UpdateAbilitiesPacket{
        $pk = new UpdateAbilitiesPacket();
        $targetActorUniqueId = LE::readSignedLong($in);
        $playerPermission = Byte::readUnsigned($in);
        $commandPermission = Byte::readUnsigned($in);

        $layerCount = Byte::readUnsigned($in);
        $layers = [];
        for($i = 0; $i < $layerCount; ++$i){
            $layers[] = $codec->read(AbilitiesLayer::class, $in);
        }

        $pk->data = new AbilitiesData(
            commandPermission: $commandPermission,
            playerPermission: $playerPermission,
            targetActorUniqueId: $targetActorUniqueId,
            abilityLayers: $layers
        );
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof UpdateAbilitiesPacket);
        LE::writeSignedLong($out, $pk->data->targetActorUniqueId);
        Byte::writeUnsigned($out, $pk->data->playerPermission);
        Byte::writeUnsigned($out, $pk->data->commandPermission);
        Byte::writeUnsigned($out, count($pk->data->abilityLayers));
        foreach($pk->data->abilityLayers as $layer){
            $codec->write(AbilitiesLayer::class, $out, $layer);
        }
    }
}
