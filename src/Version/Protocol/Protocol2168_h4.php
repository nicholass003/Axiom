<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v2168_h4\Serializer\Score\ScorePacketEntrySerializer;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol2168_h4 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol2168::buildCodecType()->fork();
        $codec->override(ScorePacketEntry::class, new ScorePacketEntrySerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol2168::build($mc)->fork(ProtocolVersion::v2168, $mc?->__toString() ?? "1.26.44")
            ->overrideCodecType(self::buildCodecType());
    }
}
