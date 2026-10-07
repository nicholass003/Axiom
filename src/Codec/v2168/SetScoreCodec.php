<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Enum\SetScorePacketType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetScorePacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SetScoreCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetScorePacket{
        $pk = new SetScorePacket();
        $pk->type = SetScorePacketType::CHANGE;
        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->read(ScorePacketEntry::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetScorePacket);
        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => $codec->write(ScorePacketEntry::class, $o, $v));
    }
}
