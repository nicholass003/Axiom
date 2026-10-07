<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPreset;
use Nicholass003\Axiom\Packet\CameraAimAssistPresetsPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraAimAssistPresetsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CameraAimAssistPresetsPacket{
        $pk = new CameraAimAssistPresetsPacket();
        $pk->categories = CodecHelper::readList($in, fn($i) => $codec->read(CameraAimAssistCategory::class, $i));
        $pk->presets = CodecHelper::readList($in, fn($i) => $codec->read(CameraAimAssistPreset::class, $i));
        $pk->operation = Byte::readUnsigned($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CameraAimAssistPresetsPacket);
        CodecHelper::writeList($out, $pk->categories, fn($out, $v) => $codec->write(CameraAimAssistCategory::class, $out, $v));
        CodecHelper::writeList($out, $pk->presets, fn($out, $v) => $codec->write(CameraAimAssistPreset::class, $out, $v));
        Byte::writeUnsigned($out, $pk->operation);
    }
}
