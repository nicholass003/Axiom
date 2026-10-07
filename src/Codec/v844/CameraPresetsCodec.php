<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Camera\CameraPreset;
use Nicholass003\Axiom\Packet\CameraPresetsPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraPresetsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CameraPresetsPacket{
        $pk = new CameraPresetsPacket();
        $pk->presets = CodecHelper::readList($in, fn($i) => $codec->read(CameraPreset::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CameraPresetsPacket);
        CodecHelper::writeList($out, $pk->presets, fn($o, $v) => $codec->write(CameraPreset::class, $o, $v));
    }
}
