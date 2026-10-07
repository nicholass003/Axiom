<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Entity\UpdateAttribute;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\UpdateAttributesPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class UpdateAttributesCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : UpdateAttributesPacket{
        $pk = new UpdateAttributesPacket();

        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);

        $pk->entries = CodecHelper::readList($in, fn($i) => $codec->read(UpdateAttribute::class, $i));

        $pk->tick = VarInt::readUnsignedLong($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof UpdateAttributesPacket);

        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);

        CodecHelper::writeList($out, $pk->entries, fn($o, $v) => $codec->write(UpdateAttribute::class, $o, $v));

        VarInt::writeUnsignedLong($out, $pk->tick);
    }
}
