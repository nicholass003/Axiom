<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Biome\BiomeDefinitionData;
use Nicholass003\Axiom\Packet\BiomeDefinitionListPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeDefinitionListCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : BiomeDefinitionListPacket{
        $pk = new BiomeDefinitionListPacket();
        $pk->definitionData = CodecHelper::readList($in, fn($i) => $codec->read(BiomeDefinitionData::class, $i));
        $pk->strings = CodecHelper::readList($in, fn($i) => CodecHelper::readString($i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof BiomeDefinitionListPacket);
        CodecHelper::writeList($out, $pk->definitionData, fn($out, $v) => $codec->write(BiomeDefinitionData::class, $out, $v));
        CodecHelper::writeList($out, $pk->strings, fn($out, $v) => CodecHelper::writeString($out, $v));
    }
}
