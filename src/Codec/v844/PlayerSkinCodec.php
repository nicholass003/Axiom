<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerSkinPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PlayerSkinCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayerSkinPacket{
        $pk = new PlayerSkinPacket();
        $pk->uuid = CodecHelper::readUuid($in);
        $pk->skin = $codec->read(SkinData::class, $in);
        $pk->newSkinName = CodecHelper::readString($in);
        $pk->oldSkinName = CodecHelper::readString($in);
        $pk->isVerified = CodecHelper::readBool($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayerSkinPacket);
        CodecHelper::writeUuid($out, $pk->uuid);
        $codec->write(SkinData::class, $out, $pk->skin);
        CodecHelper::writeString($out, $pk->newSkinName);
        CodecHelper::writeString($out, $pk->oldSkinName);
        CodecHelper::writeBool($out, $pk->isVerified);
    }
}
