<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Score\ScoreboardIdentityPacketEntry;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetScoreboardIdentityPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SetScoreboardIdentityCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetScoreboardIdentityPacket{
        $pk = new SetScoreboardIdentityPacket();

        $pk->entries = CodecHelper::readList($in, fn($in) => $codec->read(ScoreboardIdentityPacketEntry::class, $in));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetScoreboardIdentityPacket);

        CodecHelper::writeList($out, $pk->entries, fn($out, $entry) => $codec->write(ScoreboardIdentityPacketEntry::class, $out, $entry));
    }
}
