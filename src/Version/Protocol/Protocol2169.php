<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol2169 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        return Protocol2168::buildCodecType()->fork();
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol2168::build($mc)->fork(ProtocolVersion::v2169, $mc?->__toString() ?? "1.26.45");
    }
}
