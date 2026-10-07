<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\AnvilDamagePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class AnvilDamageCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : AnvilDamagePacket{
        $pk = new AnvilDamagePacket();
        $pk->blockPosition = CodecHelper::readSignedBlockPosition($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof AnvilDamagePacket);
        CodecHelper::writeSignedBlockPosition($out, $pk->blockPosition);
    }
}
