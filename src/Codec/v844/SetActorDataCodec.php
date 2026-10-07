<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\MetadataEntry;
use Nicholass003\Axiom\Data\Type\PropertySyncData;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetActorDataPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SetActorDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetActorDataPacket{
        $pk = new SetActorDataPacket();
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->metadata = CodecHelper::readList($in, fn($i) => $codec->read(MetadataEntry::class, $i));
        $pk->syncedProperties = $codec->read(PropertySyncData::class, $in);
        $pk->tick = VarInt::readUnsignedLong($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetActorDataPacket);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        CodecHelper::writeList($out, $pk->metadata, fn($o, $v) => $codec->write(MetadataEntry::class, $o, $v));
        $codec->write(PropertySyncData::class, $out, $pk->syncedProperties);
        VarInt::writeUnsignedLong($out, $pk->tick);
    }
}
