<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v859;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraFovInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraTargetInstruction;
use Nicholass003\Axiom\Packet\CameraInstructionPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraInstructionCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CameraInstructionPacket{
        $pk = new CameraInstructionPacket();
        $pk->set = CodecHelper::readOptional($in, fn($i) => $codec->read(CameraSetInstruction::class, $i));
        $pk->clear = CodecHelper::readOptional($in, CodecHelper::readBool(...));
        $pk->fade = CodecHelper::readOptional($in, fn($i) => $codec->read(CameraFadeInstruction::class, $i));
        $pk->target = CodecHelper::readOptional($in, fn($i) => $codec->read(CameraTargetInstruction::class, $i));
        $pk->removeTarget = CodecHelper::readOptional($in, CodecHelper::readBool(...));
        $pk->fieldOfView = CodecHelper::readOptional($in, fn($i) => $codec->read(CameraFovInstruction::class, $i));
        $pk->spline = CodecHelper::readOptional($in, fn($i) => $codec->read(CameraSplineInstruction::class, $i));
        $pk->attachToEntity = CodecHelper::readOptional($in, LE::readSignedLong(...));
        $pk->detachFromEntity = CodecHelper::readOptional($in, CodecHelper::readBool(...));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CameraInstructionPacket);
        CodecHelper::writeOptional($out, $pk->set, fn($o, $v) => $codec->write(CameraSetInstruction::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->clear, CodecHelper::writeBool(...));
        CodecHelper::writeOptional($out, $pk->fade, fn($o, $v) => $codec->write(CameraFadeInstruction::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->target, fn($o, $v) => $codec->write(CameraTargetInstruction::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->removeTarget, CodecHelper::writeBool(...));
        CodecHelper::writeOptional($out, $pk->fieldOfView, fn($o, $v) => $codec->write(CameraFovInstruction::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->spline, fn($o, $v) => $codec->write(CameraSplineInstruction::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->attachToEntity, LE::writeSignedLong(...));
        CodecHelper::writeOptional($out, $pk->detachFromEntity, CodecHelper::writeBool(...));
    }
}
