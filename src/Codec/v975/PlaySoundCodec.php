<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\BlockPosition;
use Nicholass003\Axiom\Data\Type\Vec3;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class PlaySoundCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlaySoundPacket{
        $pk = new PlaySoundPacket();
        $pk->soundName = CodecHelper::readString($in);
        $blockPosition = CodecHelper::readSignedBlockPosition($in);
        $pk->position = new Vec3(
            $blockPosition->x / 8,
            $blockPosition->y / 8,
            $blockPosition->z / 8
        );
        $pk->volume = LE::readFloat($in);
        $pk->pitch = LE::readFloat($in);
        $pk->serverSoundHandle = CodecHelper::readOptional($in, LE::readUnsignedLong(...));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlaySoundPacket);
        CodecHelper::writeString($out, $pk->soundName);
        CodecHelper::writeSignedBlockPosition($out, new BlockPosition(
            (int) ($pk->position->x * 8),
            (int) ($pk->position->y * 8),
            (int) ($pk->position->z * 8)
        ));
        LE::writeFloat($out, $pk->volume);
        LE::writeFloat($out, $pk->pitch);
        CodecHelper::writeOptional($out, $pk->serverSoundHandle, LE::writeUnsignedLong(...));
    }
}
