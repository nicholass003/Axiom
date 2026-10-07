<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Education\EducationUriResource;
use Nicholass003\Axiom\Packet\EduUriResourcePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EduUriResourceCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : EduUriResourcePacket{
        $pk = new EduUriResourcePacket();
        $pk->resource = $codec->read(EducationUriResource::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof EduUriResourcePacket);
        $codec->write(EducationUriResource::class, $out, $pk->resource);
    }
}
