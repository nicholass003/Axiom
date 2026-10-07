<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PurchaseReceiptPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PurchaseReceiptCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PurchaseReceiptPacket{
        $pk = new PurchaseReceiptPacket();
        $pk->entries = CodecHelper::readList($in, fn($i) => CodecHelper::readString($i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PurchaseReceiptPacket);
        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => CodecHelper::writeString($o, $v));
    }
}
