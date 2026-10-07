<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Attribute;
use Nicholass003\Axiom\Data\Type\MetadataEntry;
use Nicholass003\Axiom\Data\Type\PropertySyncData;
use Nicholass003\Axiom\Packet\AddActorPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AddActorCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : AddActorPacket{
        $pk = new AddActorPacket();
        $pk->actorUniqueId = CodecHelper::readActorUniqueId($in);
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->type = CodecHelper::readString($in);
        $pk->position = CodecHelper::readVec3($in);
        $pk->motion = CodecHelper::readVec3Nullable($in);
        $pk->pitch = LE::readFloat($in);
        $pk->yaw = LE::readFloat($in);
        $pk->headYaw = LE::readFloat($in);
        $pk->bodyYaw = LE::readFloat($in);

        $pk->attributes = CodecHelper::readList($in, fn($i) => $codec->read(Attribute::class, $i));

        $pk->metadata = CodecHelper::readList($in, fn($i) => $codec->read(MetadataEntry::class, $i));
        $pk->syncedProperties = $codec->read(PropertySyncData::class, $in);

        $pk->links = CodecHelper::readList($in, CodecHelper::readEntityLink(...));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof AddActorPacket);
        CodecHelper::writeActorUniqueId($out, $pk->actorUniqueId);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        CodecHelper::writeString($out, $pk->type);
        CodecHelper::writeVec3($out, $pk->position);
        CodecHelper::writeVec3Nullable($out, $pk->motion);
        LE::writeFloat($out, $pk->pitch);
        LE::writeFloat($out, $pk->yaw);
        LE::writeFloat($out, $pk->headYaw);
        LE::writeFloat($out, $pk->bodyYaw);

        CodecHelper::writeList($out, $pk->attributes, fn($o, $v) => $codec->write(Attribute::class, $o, $v));

        CodecHelper::writeList($out, $pk->metadata, fn($o, $v) => $codec->write(MetadataEntry::class, $o, $v));
        $codec->write(PropertySyncData::class, $out, $pk->syncedProperties);

        CodecHelper::writeList($out, $pk->links, CodecHelper::writeEntityLink(...));
    }
}
