<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\SerializableVoxelShape;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\VoxelShapesPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class VoxelShapesCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : VoxelShapesPacket{
        $pk = new VoxelShapesPacket();
        $pk->shapes = CodecHelper::readList($in, fn($i) => $codec->read(SerializableVoxelShape::class, $i));
        for($i = 0, $namesCount = VarInt::readUnsignedInt($in); $i < $namesCount; ++$i){
            $name = CodecHelper::readString($in);
            $id = LE::readUnsignedShort($in);
            $pk->nameMap[$name] = $id;
        }
        $pk->customShapeCount = LE::readUnsignedShort($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof VoxelShapesPacket);
        CodecHelper::writeList($out, $pk->shapes, fn($o, $v) => $codec->write(SerializableVoxelShape::class, $o, $v));
        VarInt::writeUnsignedInt($out, count($pk->nameMap));
        foreach($pk->nameMap as $name => $id){
            CodecHelper::writeString($out, $name);
            LE::writeUnsignedShort($out, $id);
        }
        LE::writeUnsignedShort($out, $pk->customShapeCount);
    }
}
