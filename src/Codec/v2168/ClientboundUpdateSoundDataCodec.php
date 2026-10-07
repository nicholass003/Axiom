<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Sound\SoundDataEvent;
use Nicholass003\Axiom\Packet\ClientboundUpdateSoundDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ClientboundUpdateSoundDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientboundUpdateSoundDataPacket{
        $pk = new ClientboundUpdateSoundDataPacket();

        $pk->serverSoundHandle = LE::readUnsignedLong($in);
        $pk->stopEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->volumeEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->pitchEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->fadeEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->seekToEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->pauseEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));
        $pk->resumeEvent = CodecHelper::readOptional($in, fn($in) => $codec->read(SoundDataEvent::class, $in));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundUpdateSoundDataPacket);
        LE::writeUnsignedLong($out, $pk->serverSoundHandle);

        CodecHelper::writeOptional($out, $pk->stopEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->volumeEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->pitchEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->fadeEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->seekToEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->pauseEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
        CodecHelper::writeOptional($out, $pk->resumeEvent, fn($out, $v) => $codec->write(SoundDataEvent::class, $out, $v));
    }
}
