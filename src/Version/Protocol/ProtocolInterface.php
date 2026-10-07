<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;

interface ProtocolInterface{

    public static function buildCodecType() : CodecType;

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder;
}
