<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineDefinition;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Packet\CameraSplinePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraSplineCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CameraSplinePacket{
        $pk = new CameraSplinePacket();
        $pk->splines = CodecHelper::readList($in, function($in) use ($codec) {
            $name = CodecHelper::readString($in);
            $instruction = $codec->read(CameraSplineInstruction::class, $in);
            return new CameraSplineDefinition($name, $instruction);
        });
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CameraSplinePacket);
        CodecHelper::writeList($out, $pk->splines, function($out, $spline) use ($codec) {
            CodecHelper::writeString($out, $spline->name);
            $codec->write(CameraSplineInstruction::class, $out, $spline->instruction);
        });
    }
}
