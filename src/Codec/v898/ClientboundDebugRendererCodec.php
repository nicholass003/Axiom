<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Debug\DebugMarkerData;
use Nicholass003\Axiom\Enum\ClientboundDebugRendererType;
use Nicholass003\Axiom\Packet\ClientboundDebugRendererPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ClientboundDebugRendererCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientboundDebugRendererPacket{
        $pk = new ClientboundDebugRendererPacket();
        $pk->type = ClientboundDebugRendererType::fromString(CodecHelper::readString($in));
        $pk->data = CodecHelper::readOptional($in, fn($i) => $codec->read(DebugMarkerData::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundDebugRendererPacket);
        CodecHelper::writeString($out, $pk->type->toString());
        CodecHelper::writeOptional($out, $pk->data, fn($o, $v) => $codec->write(DebugMarkerData::class, $o, $v));
    }
}
