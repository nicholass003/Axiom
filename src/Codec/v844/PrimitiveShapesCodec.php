<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Debug\PacketShapeData;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PrimitiveShapesPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PrimitiveShapesCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PrimitiveShapesPacket{
        $pk = new PrimitiveShapesPacket();
        $pk->shapes = CodecHelper::readList($in, fn($i) => $codec->read(PacketShapeData::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PrimitiveShapesPacket);
        CodecHelper::writeList($out, $pk->shapes, fn($o, $v) => $codec->write(PacketShapeData::class, $o, $v));
    }
}
