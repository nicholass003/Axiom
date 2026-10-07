<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\EmoteListPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EmoteListCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : EmoteListPacket{
        $pk = new EmoteListPacket();
        $pk->playerActorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->emoteIds = CodecHelper::readList($in, fn($i) => CodecHelper::readUuid($i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof EmoteListPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->playerActorRuntimeId);
        CodecHelper::writeList($out, $pk->emoteIds, fn($o, $v) => CodecHelper::writeUuid($o, $v));
    }
}
