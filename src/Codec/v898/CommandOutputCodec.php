<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Data\Type\Command\CommandOutputMessage;
use Nicholass003\Axiom\Enum\CommandOutputType;
use Nicholass003\Axiom\Packet\CommandOutputPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandOutputCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CommandOutputPacket{
        $pk = new CommandOutputPacket();
        $pk->originData = $codec->read(CommandOriginData::class, $in);
        $pk->outputType = CommandOutputType::fromString(CodecHelper::readString($in));
        $pk->successCount = LE::readUnsignedInt($in);
        $pk->messages = CodecHelper::readList($in, fn($i) => $codec->read(CommandOutputMessage::class, $i));
        $pk->data = CodecHelper::readOptional($in, CodecHelper::readString(...));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CommandOutputPacket);
        $codec->write(CommandOriginData::class, $out, $pk->originData);
        CodecHelper::writeString($out, $pk->outputType->toString());
        LE::writeUnsignedInt($out, $pk->successCount);
        CodecHelper::writeList($out, $pk->messages, fn($out, $m) => $codec->write(CommandOutputMessage::class, $out, $m));
        CodecHelper::writeOptional($out, $pk->data, CodecHelper::writeString(...));
    }
}
