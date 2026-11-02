<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackInfoEntry;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ResourcePacksInfoPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ResourcePacksInfoCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ResourcePacksInfoPacket{
        $pk = new ResourcePacksInfoPacket();
        $pk->mustAccept = CodecHelper::readBool($in);
        $pk->hasAddons = CodecHelper::readBool($in);
        $pk->hasScripts = CodecHelper::readBool($in);
        $pk->forceDisableVibrantVisuals = CodecHelper::readBool($in);
        $pk->worldTemplateId = CodecHelper::readUUID($in);
        $pk->worldTemplateVersion = CodecHelper::readString($in);

        $pk->resourcePackEntries = CodecHelper::readList($in, fn($i) => $codec->read(ResourcePackInfoEntry::class, $i));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ResourcePacksInfoPacket);
        CodecHelper::writeBool($out, $pk->mustAccept);
        CodecHelper::writeBool($out, $pk->hasAddons);
        CodecHelper::writeBool($out, $pk->hasScripts);
        CodecHelper::writeBool($out, $pk->forceDisableVibrantVisuals);
        CodecHelper::writeUUID($out, $pk->worldTemplateId);
        CodecHelper::writeString($out, $pk->worldTemplateVersion);

        CodecHelper::writeList($out, $pk->resourcePackEntries, fn($entry) => $codec->write(ResourcePackInfoEntry::class, $out, $entry));
    }
}
