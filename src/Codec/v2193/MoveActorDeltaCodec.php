<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\MoveActorDeltaPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class MoveActorDeltaCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : MoveActorDeltaPacket{
        $pk = new MoveActorDeltaPacket();
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->xPos = CodecHelper::readOptional($in, LE::readFloat(...));
        $pk->yPos = CodecHelper::readOptional($in, LE::readFloat(...));
        $pk->zPos = CodecHelper::readOptional($in, LE::readFloat(...));
        $pk->pitch = CodecHelper::readOptional($in, CodecHelper::readRotationByte(...));
        $pk->yaw = CodecHelper::readOptional($in, CodecHelper::readRotationByte(...));
        $pk->headYaw = CodecHelper::readOptional($in, CodecHelper::readRotationByte(...));
        $pk->onGround = CodecHelper::readBool($in);
        $pk->teleport = CodecHelper::readBool($in);
        $pk->forceMoveLocalEntity = CodecHelper::readBool($in);
        $pk->forceCompletion = CodecHelper::readBool($in);
        $pk->ticks = VarInt::readUnsignedLong($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof MoveActorDeltaPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        CodecHelper::writeOptional($out, $pk->xPos, LE::writeFloat(...));
        CodecHelper::writeOptional($out, $pk->yPos, LE::writeFloat(...));
        CodecHelper::writeOptional($out, $pk->zPos, LE::writeFloat(...));
        CodecHelper::writeOptional($out, $pk->pitch, CodecHelper::writeRotationByte(...));
        CodecHelper::writeOptional($out, $pk->yaw, CodecHelper::writeRotationByte(...));
        CodecHelper::writeOptional($out, $pk->headYaw, CodecHelper::writeRotationByte(...));
        CodecHelper::writeBool($out, $pk->onGround);
        CodecHelper::writeBool($out, $pk->teleport);
        CodecHelper::writeBool($out, $pk->forceMoveLocalEntity);
        CodecHelper::writeBool($out, $pk->forceCompletion);
        VarInt::writeUnsignedLong($out, $pk->ticks);
    }
}