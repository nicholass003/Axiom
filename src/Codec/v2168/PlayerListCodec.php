<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\Color;
use Nicholass003\Axiom\Data\Type\PlayerListEntry;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Enum\PlayerListType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerListPacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PlayerListCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayerListPacket{
        $pk = new PlayerListPacket();
        $count = VarInt::readUnsignedInt($in);

        for($i = 0; $i < $count; ++$i){
            $type = PlayerListType::from(VarInt::readUnsignedInt($in));
            $innerType = PlayerListType::fromOrdinal(Byte::readUnsigned($in));

            if($innerType !== $type){
                throw new \RuntimeException("Unexpected inner type $innerType for player list entry type $type, expected $type");
            }

            if($type === PlayerListType::REMOVE){
                $uuid = CodecHelper::readUUID($in);
                $pk->entries[] = new PlayerListEntry($uuid, type: $type);
            }elseif($type === PlayerListType::ADD){
                $uuid = CodecHelper::readUUID($in);
                $actorUniqueId = CodecHelper::readActorUniqueId($in);
                $username = CodecHelper::readString($in);
                $xboxUserId = CodecHelper::readString($in);
                $platformChatId = CodecHelper::readString($in);
                $buildPlatform = LE::readSignedInt($in);
                $skin = $codec->read(SkinData::class, $in);
                $isTeacher = CodecHelper::readBool($in);
                $isHost = CodecHelper::readBool($in);
                $isSubClient = CodecHelper::readBool($in);
                $color = CodecHelper::readColor($in)->toARGB();

                $pk->entries[] = new PlayerListEntry(
                    $uuid,
                    $actorUniqueId,
                    $username,
                    $xboxUserId,
                    $platformChatId,
                    $buildPlatform,
                    $skin,
                    $isTeacher,
                    $isHost,
                    $isSubClient,
                    $color,
                    null,
                    $type
                );
            }else{
                throw new \RuntimeException("Unknown player list entry type $type");
            }
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayerListPacket);
        VarInt::writeUnsignedInt($out, count($pk->entries));

        foreach($pk->entries as $entry){
            if($entry->type === PlayerListType::REMOVE){
                VarInt::writeUnsignedInt($out, $entry->type->value);
                Byte::writeUnsigned($out, $entry->type->toOrdinal());
                CodecHelper::writeUUID($out, $entry->uuid);
            }elseif($entry->type === PlayerListType::ADD){
                VarInt::writeUnsignedInt($out, $entry->type->value);
                Byte::writeUnsigned($out, $entry->type->toOrdinal());
                CodecHelper::writeUUID($out, $entry->uuid);
                CodecHelper::writeActorUniqueId($out, $entry->actorUniqueId ?? 0);
                CodecHelper::writeString($out, $entry->username ?? "");
                CodecHelper::writeString($out, $entry->xboxUserId ?? "");
                CodecHelper::writeString($out, $entry->platformChatId ?? "");
                LE::writeSignedInt($out, $entry->buildPlatform ?? -1);
                $codec->write(SkinData::class, $out, $entry->skinData);
                CodecHelper::writeBool($out, $entry->isTeacher ?? false);
                CodecHelper::writeBool($out, $entry->isHost ?? false);
                CodecHelper::writeBool($out, $entry->isSubClient ?? false);
                CodecHelper::writeColor($out, Color::fromARGB($entry->color ?? 0xFFFFFFFF));
            }
        }
    }
}
