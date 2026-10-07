<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Vec3;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PlaySoundCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlaySoundPacket{
        $pk = new PlaySoundPacket();
        $pk->soundName = CodecHelper::readString($in);
        $pk->position = new Vec3(
            LE::readSignedInt($in) / 8,
            LE::readSignedInt($in) / 8,
            LE::readSignedInt($in) / 8
        );
        $pk->volume = LE::readFloat($in);
        $pk->pitch = LE::readFloat($in);
        $pk->loopCount = VarInt::readSignedInt($in);
        $pk->bypassListenerRangeCheck = CodecHelper::readBool($in);
        $pk->serverSoundHandle = CodecHelper::readOptional($in, LE::readUnsignedLong(...));
        $pk->playbackPositionSeconds = CodecHelper::readOptional($in, LE::readFloat(...));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlaySoundPacket);
        CodecHelper::writeString($out, $pk->soundName);
        LE::writeSignedInt($out, (int) ($pk->position->x * 8));
        LE::writeSignedInt($out, (int) ($pk->position->y * 8));
        LE::writeSignedInt($out, (int) ($pk->position->z * 8));
        LE::writeFloat($out, $pk->volume);
        LE::writeFloat($out, $pk->pitch);
        VarInt::writeSignedInt($out, $pk->loopCount);
        CodecHelper::writeBool($out, $pk->bypassListenerRangeCheck);
        CodecHelper::writeOptional($out, $pk->serverSoundHandle, LE::writeUnsignedLong(...));
        CodecHelper::writeOptional($out, $pk->playbackPositionSeconds, LE::writeFloat(...));
    }
}