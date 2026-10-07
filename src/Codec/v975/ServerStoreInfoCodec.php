<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ClientStoreEntrypointConfig;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ServerStoreInfoPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ServerStoreInfoCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ServerStoreInfoPacket{
        $pk = new ServerStoreInfoPacket();
        $pk->clientStoreEntrypointConfig = CodecHelper::readOptional($in, fn($i) => $codec->read(ClientStoreEntrypointConfig::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ServerStoreInfoPacket);
        CodecHelper::writeOptional($out, $pk->clientStoreEntrypointConfig, fn($o, $v) => $codec->write(ClientStoreEntrypointConfig::class, $o, $v));
    }
}
