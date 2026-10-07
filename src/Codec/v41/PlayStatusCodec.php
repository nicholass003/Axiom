<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v41;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\LegacyBinaryStreamHelper as Binary;
use Nicholass003\Axiom\Packet\Legacy\PlayStatusPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

/** @since v41 */
class PlayStatusCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayStatusPacket{
        $pk = new PlayStatusPacket();
        $pk->status = Binary::readInt($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayStatusPacket);
        Binary::writeInt($out, $pk->status);
    }
}
