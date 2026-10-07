<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\MetadataEntry;
use Nicholass003\Axiom\Packet\AddItemActorPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class AddItemActorCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : AddItemActorPacket{
        $pk = new AddItemActorPacket();
        $pk->actorUniqueId = CodecHelper::readActorUniqueId($in);
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->item = $codec->read(ItemStackWrapper::class, $in);
        $pk->position = CodecHelper::readVec3($in);
        $pk->motion = CodecHelper::readVec3Nullable($in);
        $pk->metadata = CodecHelper::readList($in, fn($i) => $codec->read(MetadataEntry::class, $i));
        $pk->isFromFishing = CodecHelper::readBool($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof AddItemActorPacket);
        CodecHelper::writeActorUniqueId($out, $pk->actorUniqueId);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        $codec->write(ItemStackWrapper::class, $out, $pk->item);
        CodecHelper::writeVec3($out, $pk->position);
        CodecHelper::writeVec3Nullable($out, $pk->motion);
        CodecHelper::writeList($out, $pk->metadata, fn($o, $v) => $codec->write(MetadataEntry::class, $o, $v));
        CodecHelper::writeBool($out, $pk->isFromFishing);
    }
}
