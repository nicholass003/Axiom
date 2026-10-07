<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Score\ScoreboardIdentityPacketEntry;
use Nicholass003\Axiom\Enum\SetScoreboardIdentityType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetScoreboardIdentityPacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SetScoreboardIdentityCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetScoreboardIdentityPacket{
        $pk = new SetScoreboardIdentityPacket();
        $pk->type = SetScoreboardIdentityType::safe(Byte::readUnsigned($in));
        $isRegister = $pk->type === SetScoreboardIdentityType::REGISTER_IDENTITY;
        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->get(ScoreboardIdentityPacketEntry::class)->read($i, $codec, $isRegister));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetScoreboardIdentityPacket);
        Byte::writeUnsigned($out, $pk->type->value);
        $isRegister = $pk->type === SetScoreboardIdentityType::REGISTER_IDENTITY;
        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => $codec->get(ScoreboardIdentityPacketEntry::class)->write($o, $v, $codec, $isRegister));
    }
}
