<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Enum\PlayerLocationType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerLocationPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class PlayerLocationCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayerLocationPacket{
        $pk = new PlayerLocationPacket();
        $pk->actorUniqueId = CodecHelper::readActorUniqueId($in);
        $pk->type = PlayerLocationType::safe(VarInt::readUnsignedInt($in));
        $innerType = VarInt::readSignedInt($in);
        if($innerType !== $pk->type->value){
            throw new \RuntimeException("Unexpected inner type, expected {$pk->type->value}, got $innerType");
        }

        if($pk->type === PlayerLocationType::COORDINATES){
            $pk->position = CodecHelper::readVec3($in);
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayerLocationPacket);
        CodecHelper::writeActorUniqueId($out, $pk->actorUniqueId ?? 0);
        VarInt::writeUnsignedInt($out, $pk->type->value);
        VarInt::writeSignedInt($out, $pk->type->value);

        if($pk->type === PlayerLocationType::COORDINATES){
            if($pk->position === null){
                throw new \LogicException("PlayerLocationPacket with type COORDINATES requires a position");
            }
            CodecHelper::writeVec3($out, $pk->position);
        }
    }
}
