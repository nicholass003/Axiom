<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Experiments;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackStackEntry;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ResourcePackStackPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ResourcePackStackCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ResourcePackStackPacket{
        $pk = new ResourcePackStackPacket();
        $pk->mustAccept = CodecHelper::readBool($in);

        $pk->behaviorPackStack = CodecHelper::readList($in, fn($i) => $codec->read(ResourcePackStackEntry::class, $i));
        $pk->resourcePackStack = CodecHelper::readList($in, fn($i) => $codec->read(ResourcePackStackEntry::class, $i));

        $pk->baseGameVersion = CodecHelper::readString($in);
        $pk->experiments = $codec->read(Experiments::class, $in);
        $pk->useVanillaEditorPacks = CodecHelper::readBool($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ResourcePackStackPacket);
        CodecHelper::writeBool($out, $pk->mustAccept);

        CodecHelper::writeList($out, $pk->behaviorPackStack, fn($o, $v) => $codec->write(ResourcePackStackEntry::class, $o, $v));
        CodecHelper::writeList($out, $pk->resourcePackStack, fn($o, $v) => $codec->write(ResourcePackStackEntry::class, $o, $v));

        CodecHelper::writeString($out, $pk->baseGameVersion);
        $codec->write(Experiments::class, $out, $pk->experiments);
        CodecHelper::writeBool($out, $pk->useVanillaEditorPacks);
    }
}
