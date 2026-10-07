<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\MetadataEntry;
use Nicholass003\Axiom\Data\Type\PropertySyncData;
use Nicholass003\Axiom\Packet\AddPlayerPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class AddPlayerCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : AddPlayerPacket{
        $pk = new AddPlayerPacket();
        $pk->uuid = CodecHelper::readUuid($in);
        $pk->username = CodecHelper::readString($in);
        $pk->actorRuntimeId = CodecHelper::readActorRuntimeId($in);
        $pk->platformChatId = CodecHelper::readString($in);
        $pk->position = CodecHelper::readVec3($in);
        $pk->motion = CodecHelper::readVec3Nullable($in);
        $pk->pitch = LE::readFloat($in);
        $pk->yaw = LE::readFloat($in);
        $pk->headYaw = LE::readFloat($in);
        $pk->item = $codec->read(ItemStackWrapper::class, $in);
        $pk->gameMode = VarInt::readSignedInt($in);
        $pk->metadata = CodecHelper::readList($in, fn($i) => $codec->read(MetadataEntry::class, $i));
        $pk->syncedProperties = $codec->read(PropertySyncData::class, $in);

        $abilitiesCodec = new UpdateAbilitiesCodec();
        $pk->abilitiesPacket = $abilitiesCodec->decode($in, $codec);

        $linkCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $linkCount; ++$i){
            $pk->links[] = CodecHelper::readEntityLink($in);
        }

        $pk->deviceId = CodecHelper::readString($in);
        $pk->buildPlatform = LE::readSignedInt($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof AddPlayerPacket);
        CodecHelper::writeUuid($out, $pk->uuid);
        CodecHelper::writeString($out, $pk->username);
        CodecHelper::writeActorRuntimeId($out, $pk->actorRuntimeId);
        CodecHelper::writeString($out, $pk->platformChatId);
        CodecHelper::writeVec3($out, $pk->position);
        CodecHelper::writeVec3Nullable($out, $pk->motion);
        LE::writeFloat($out, $pk->pitch);
        LE::writeFloat($out, $pk->yaw);
        LE::writeFloat($out, $pk->headYaw);
        $codec->write(ItemStackWrapper::class, $out, $pk->item);
        VarInt::writeSignedInt($out, $pk->gameMode);
        CodecHelper::writeList($out, $pk->metadata, fn($o, $v) => $codec->write(MetadataEntry::class, $o, $v));
        $codec->write(PropertySyncData::class, $out, $pk->syncedProperties);

        $abilitiesCodec = new UpdateAbilitiesCodec();
        $abilitiesCodec->encode($out, $pk->abilitiesPacket, $codec);

        VarInt::writeUnsignedInt($out, count($pk->links));
        foreach($pk->links as $link){
            CodecHelper::writeEntityLink($out, $link);
        }

        CodecHelper::writeString($out, $pk->deviceId);
        LE::writeSignedInt($out, $pk->buildPlatform);
    }
}
