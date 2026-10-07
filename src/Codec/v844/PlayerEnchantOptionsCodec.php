<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Enchant\EnchantOption;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerEnchantOptionsPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PlayerEnchantOptionsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayerEnchantOptionsPacket{
        $pk = new PlayerEnchantOptionsPacket();
        $pk->options = CodecHelper::readList($in, fn($i) => $codec->read(EnchantOption::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayerEnchantOptionsPacket);
        CodecHelper::writeList($out, $pk->options, fn($o, $v) => $codec->write(EnchantOption::class, $o, $v));
    }
}
