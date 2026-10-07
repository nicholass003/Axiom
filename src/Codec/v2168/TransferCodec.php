<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\TransferPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class TransferCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : TransferPacket{
        $pk = new TransferPacket();

        $pk->address = CodecHelper::readString($in);
        $pk->port = LE::readUnsignedShort($in);
        $pk->reloadWorld = CodecHelper::readBool($in);
        $pk->gatheringsConfig = CodecHelper::readOptional($in, fn($in) => $codec->read(GatheringJoinInfo::class, $in));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof TransferPacket);
        CodecHelper::writeString($out, $pk->address);
        LE::writeUnsignedShort($out, $pk->port);
        CodecHelper::writeBool($out, $pk->reloadWorld);
        CodecHelper::writeOptional($out, $pk->gatheringsConfig, fn($out, $v) => $codec->write(GatheringJoinInfo::class, $out, $v));
    }
}
