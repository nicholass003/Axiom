<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Enum\SetScorePacketType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetScorePacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SetScoreCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetScorePacket{
        $pk = new SetScorePacket();
        $pk->type = SetScorePacketType::safe(Byte::readUnsigned($in));
        $isRemove = $pk->type === SetScorePacketType::REMOVE;
        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->get(ScorePacketEntry::class)->read($i, $codec, $isRemove));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetScorePacket);
        Byte::writeUnsigned($out, $pk->type->value);
        $isRemove = $pk->type === SetScorePacketType::REMOVE;
        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => $codec->get(ScorePacketEntry::class)->write($o, $v, $codec, $isRemove));
    }
}
