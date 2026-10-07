<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v859;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Enum\ShowStoreOfferRedirectType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ShowStoreOfferPacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ShowStoreOfferCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ShowStoreOfferPacket{
        $pk = new ShowStoreOfferPacket();
        $pk->offerId = CodecHelper::readUUID($in);
        $pk->redirectType = ShowStoreOfferRedirectType::safe(Byte::readUnsigned($in));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ShowStoreOfferPacket);
        CodecHelper::writeUUID($out, $pk->offerId);
        Byte::writeUnsigned($out, $pk->redirectType->value);
    }
}
