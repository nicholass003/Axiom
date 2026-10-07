<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceOptions;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SetPlayerFurnaceOptionsPacket;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SetPlayerFurnaceOptionsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SetPlayerFurnaceOptionsPacket{
        $pk = new SetPlayerFurnaceOptionsPacket();
        $pk->furnaceType = FurnaceType::fromPacket(Byte::readUnsigned($in));
        $pk->furnaceOptions = $codec->read(FurnaceOptions::class, $in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SetPlayerFurnaceOptionsPacket);
        Byte::writeUnsigned($out, $pk->furnaceType->toPacket());
        $codec->write(FurnaceOptions::class, $out, $pk->furnaceOptions);
    }
}
