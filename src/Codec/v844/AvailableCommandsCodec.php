<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumConstraintRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandSoftEnum;
use Nicholass003\Axiom\Packet\AvailableCommandsPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use function count;

class AvailableCommandsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : AvailableCommandsPacket{
        $pk = new AvailableCommandsPacket();
        $pk->enumValues = CodecHelper::readList($in, fn($in) => CodecHelper::readString($in));
        $pk->chainedSubCommandValues = CodecHelper::readList($in, fn($in) => CodecHelper::readString($in));
        $pk->postfixes = CodecHelper::readList($in, fn($in) => CodecHelper::readString($in));

        $valueListSize = count($pk->enumValues);
        $pk->enums = CodecHelper::readList($in, fn($in) => $codec->get(CommandEnumRawData::class)->read($in, $codec, $valueListSize));
        $pk->chainedSubCommandData = CodecHelper::readList($in, fn($in) => $codec->read(ChainedSubCommandRawData::class, $in));
        $pk->commandData = CodecHelper::readList($in, fn($in) => $codec->read(CommandRawData::class, $in));
        $pk->softEnums = CodecHelper::readList($in, fn($in) => $codec->read(CommandSoftEnum::class, $in));
        $pk->enumConstraints = CodecHelper::readList($in, fn($in) => $codec->read(CommandEnumConstraintRawData::class, $in));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof AvailableCommandsPacket);
        CodecHelper::writeList($out, $pk->enumValues, fn($out, $v) => CodecHelper::writeString($out, $v));
        CodecHelper::writeList($out, $pk->chainedSubCommandValues, fn($out, $v) => CodecHelper::writeString($out, $v));
        CodecHelper::writeList($out, $pk->postfixes, fn($out, $v) => CodecHelper::writeString($out, $v));

        $valueListSize = count($pk->enumValues);
        CodecHelper::writeList($out, $pk->enums, fn($out, $v) => $codec->get(CommandEnumRawData::class)->write($out, $v, $codec, $valueListSize));
        CodecHelper::writeList($out, $pk->chainedSubCommandData, fn($out, $v) => $codec->write(ChainedSubCommandRawData::class, $out, $v));
        CodecHelper::writeList($out, $pk->commandData, fn($out, $v) => $codec->write(CommandRawData::class, $out, $v));
        CodecHelper::writeList($out, $pk->softEnums, fn($out, $v) => $codec->write(CommandSoftEnum::class, $out, $v));
        CodecHelper::writeList($out, $pk->enumConstraints, fn($out, $v) => $codec->write(CommandEnumConstraintRawData::class, $out, $v));
    }
}
