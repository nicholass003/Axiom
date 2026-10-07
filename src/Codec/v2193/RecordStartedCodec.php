<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\RecordStartedPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class RecordStartedCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : RecordStartedPacket{
        $pk = new RecordStartedPacket();
        $pk->blockPosition = CodecHelper::readBlockPosition($in);
        $pk->serverSoundHandle = LE::readUnsignedLong($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof RecordStartedPacket);
        CodecHelper::writeBlockPosition($out, $pk->blockPosition);
        LE::writeUnsignedLong($out, $pk->serverSoundHandle);
    }
}
