<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Enum\MoveActorDeltaFlag;
use Nicholass003\Axiom\Packet\MoveActorDeltaPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class MoveActorDeltaCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : MoveActorDeltaPacket{
        $pk = new MoveActorDeltaPacket();
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->flags = LE::readUnsignedShort($in);

        $flags = $pk->flags;
        if(($flags & MoveActorDeltaFlag::HAS_X->value) !== 0){
            $pk->xPos = LE::readFloat($in);
        }
        if(($flags & MoveActorDeltaFlag::HAS_Y->value) !== 0){
            $pk->yPos = LE::readFloat($in);
        }
        if(($flags & MoveActorDeltaFlag::HAS_Z->value) !== 0){
            $pk->zPos = LE::readFloat($in);
        }
        if(($flags & MoveActorDeltaFlag::HAS_PITCH->value) !== 0){
            $pk->pitch = CodecHelper::readRotationByte($in);
        }
        if(($flags & MoveActorDeltaFlag::HAS_YAW->value) !== 0){
            $pk->yaw = CodecHelper::readRotationByte($in);
        }
        if(($flags & MoveActorDeltaFlag::HAS_HEAD_YAW->value) !== 0){
            $pk->headYaw = CodecHelper::readRotationByte($in);
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof MoveActorDeltaPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        LE::writeUnsignedShort($out, $pk->flags);

        $flags = $pk->flags;
        if(($flags & MoveActorDeltaFlag::HAS_X->value) !== 0){
            LE::writeFloat($out, $pk->xPos ?? 0.0);
        }
        if(($flags & MoveActorDeltaFlag::HAS_Y->value) !== 0){
            LE::writeFloat($out, $pk->yPos ?? 0.0);
        }
        if(($flags & MoveActorDeltaFlag::HAS_Z->value) !== 0){
            LE::writeFloat($out, $pk->zPos ?? 0.0);
        }
        if(($flags & MoveActorDeltaFlag::HAS_PITCH->value) !== 0){
            CodecHelper::writeRotationByte($out, $pk->pitch ?? 0.0);
        }
        if(($flags & MoveActorDeltaFlag::HAS_YAW->value) !== 0){
            CodecHelper::writeRotationByte($out, $pk->yaw ?? 0.0);
        }
        if(($flags & MoveActorDeltaFlag::HAS_HEAD_YAW->value) !== 0){
            CodecHelper::writeRotationByte($out, $pk->headYaw ?? 0.0);
        }
    }
}
