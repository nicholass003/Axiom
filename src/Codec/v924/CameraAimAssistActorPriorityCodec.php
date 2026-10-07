<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistActorPriority;
use Nicholass003\Axiom\Packet\CameraAimAssistActorPriorityPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraAimAssistActorPriorityCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CameraAimAssistActorPriorityPacket{
        $pk = new CameraAimAssistActorPriorityPacket();
        $pk->priorityData = CodecHelper::readList($in, fn($i) => $codec->read(CameraAimAssistActorPriority::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CameraAimAssistActorPriorityPacket);
        CodecHelper::writeList($out, $pk->priorityData, fn($o, $v) => $codec->write(CameraAimAssistActorPriority::class, $o, $v));
    }
}
