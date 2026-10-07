<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Packet\CommandRequestPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CommandRequestCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CommandRequestPacket{
        $pk = new CommandRequestPacket();
        $pk->command = CodecHelper::readString($in);
        $pk->originData = $codec->read(CommandOriginData::class, $in);
        $pk->isInternal = CodecHelper::readBool($in);
        $pk->version = CodecHelper::readString($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CommandRequestPacket);
        CodecHelper::writeString($out, $pk->command);
        $codec->write(CommandOriginData::class, $out, $pk->originData);
        CodecHelper::writeBool($out, $pk->isInternal);
        CodecHelper::writeString($out, is_int($pk->version) ? "latest" : $pk->version);
    }
}
