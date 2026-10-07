<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Packet\ContainerRegistryCleanupPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ContainerRegistryCleanupCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ContainerRegistryCleanupPacket{
        $pk = new ContainerRegistryCleanupPacket();
        $pk->removedContainers = CodecHelper::readList($in, fn($i) => $codec->read(FullContainerName::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ContainerRegistryCleanupPacket);
        CodecHelper::writeList($out, $pk->removedContainers, fn($o, $v) => $codec->write(FullContainerName::class, $o, $v));
    }
}
