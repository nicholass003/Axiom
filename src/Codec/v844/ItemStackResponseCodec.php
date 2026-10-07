<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponse;
use Nicholass003\Axiom\Packet\ItemStackResponsePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ItemStackResponseCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ItemStackResponsePacket{
        $pk = new ItemStackResponsePacket();
        $pk->responses = CodecHelper::readList($in, fn(ByteBufferReader $in) => $codec->read(ItemStackResponse::class, $in));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ItemStackResponsePacket);
        CodecHelper::writeList($out, $pk->responses, fn(ByteBufferWriter $out, ItemStackResponse $response) => $codec->write(ItemStackResponse::class, $out, $response));
    }
}
