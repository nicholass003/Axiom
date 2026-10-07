<?php

declare(strict_types=1);

namespace Nicholass003\Axiom;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\Protocol\Protocol1001;
use Nicholass003\Axiom\Version\Protocol\Protocol2168;
use Nicholass003\Axiom\Version\Protocol\Protocol2193;
use Nicholass003\Axiom\Version\Protocol\Protocol844;
use Nicholass003\Axiom\Version\Protocol\Protocol859;
use Nicholass003\Axiom\Version\Protocol\Protocol860;
use Nicholass003\Axiom\Version\Protocol\Protocol898;
use Nicholass003\Axiom\Version\Protocol\Protocol924;
use Nicholass003\Axiom\Version\Protocol\Protocol944;
use Nicholass003\Axiom\Version\Protocol\Protocol975;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Axiom{

    /** @var array<string, CodecBuilder> */
    private static array $cache = [];

    public static function for(int $protocol, ?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        $version = ProtocolVersion::tryFrom($protocol) ?? throw new \InvalidArgumentException("Unsupported protocol: $protocol");

        $key = $protocol . "|" . ($mc?->__toString() ?? "*");

        if(isset(self::$cache[$key])){
            return self::$cache[$key];
        }

        $builder = match($version){
            ProtocolVersion::v844 => Protocol844::build($mc),
            ProtocolVersion::v859 => Protocol859::build($mc),
            ProtocolVersion::v860 => Protocol860::build($mc),
            ProtocolVersion::v898 => Protocol898::build($mc),
            ProtocolVersion::v924 => Protocol924::build($mc),
            ProtocolVersion::v944 => Protocol944::build($mc),
            ProtocolVersion::v975 => Protocol975::build($mc),
            ProtocolVersion::v1001 => Protocol1001::build($mc),
            ProtocolVersion::v2168 => Protocol2168::build($mc),
            ProtocolVersion::v2193 => Protocol2193::build($mc),
            default => throw new \InvalidArgumentException("Protocol $protocol not yet implemented in Axiom"),
        };
        return self::$cache[$key] = $builder;
    }

    public static function clearCache() : void{
        self::$cache = [];
    }
}
