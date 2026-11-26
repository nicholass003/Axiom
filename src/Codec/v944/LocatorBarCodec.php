<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\LocatorBarWaypointPayload;
use Nicholass003\Axiom\Packet\LocatorBarPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class LocatorBarCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : LocatorBarPacket{
        $pk = new LocatorBarPacket();
        $pk->waypoints = CodecHelper::readList($in, $codec->read(LocatorBarWaypointPayload::class, $in));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof LocatorBarPacket);
        CodecHelper::writeList($out, $pk->waypoints, fn($o, $v) => $codec->write(LocatorBarWaypointPayload::class, $o, $v));
    }
}
