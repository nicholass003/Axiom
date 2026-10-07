<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v41;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\LegacyBinaryStreamHelper as Binary;
use Nicholass003\Axiom\Packet\Legacy\DisconnectPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

/** @since v41 */
class DisconnectCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : DisconnectPacket{
        $pk = new DisconnectPacket();
        $pk->message = Binary::readString($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof DisconnectPacket);
        Binary::writeString($out, $pk->message);
    }
}
