<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\DimensionData;
use Nicholass003\Axiom\Packet\DimensionDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class DimensionDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : DimensionDataPacket{
        $pk = new DimensionDataPacket();
        $count = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $dimensionName = CodecHelper::readString($in);
            $pk->definitions[$dimensionName] = $codec->read(DimensionData::class, $in);
        }
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof DimensionDataPacket);
        VarInt::writeUnsignedInt($out, count($pk->definitions));
        foreach($pk->definitions as $name => $data){
            CodecHelper::writeString($out, $name);
            $codec->write(DimensionData::class, $out, $data);
        }
    }
}
