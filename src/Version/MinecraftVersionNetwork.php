<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version;

class MinecraftVersionNetwork{

    public int $major;
    public int $minor;
    public int $patch;
    public int $hotfix;

    public function __construct(string $versionString){
        $normalized = str_replace(" ", "", $versionString);
        $parts = explode(".", $normalized);

        $this->major = isset($parts[0]) ? (int) $parts[0] : 0;
        $this->minor = isset($parts[1]) ? (int) $parts[1] : 0;

        $rawPatch = isset($parts[2]) ? (int) $parts[2] : 0;

        $this->patch = (int) (floor($rawPatch / 10) * 10);
        $this->hotfix = $rawPatch % 10;
    }

    public static function from(string $version) : self{
        return new self($version);
    }

    public static function tryFrom(string $version) : ?self{
        try{
            return self::from($version);
        }catch(\InvalidArgumentException $e){
            return null;
        }
    }

    public function isHotfix() : bool{
        return $this->hotfix > 0;
    }

    public function getMajor() : int{
        return $this->major;
    }

    public function getMinor() : int{
        return $this->minor;
    }

    public function getPatch() : int{
        return $this->patch;
    }

    public function getHotfix() : int{
        return $this->hotfix;
    }

    public function isAtLeast(string $version) : bool{
        return version_compare($this->__toString(), $version, ">=");
    }

    public function isBelow(string $version) : bool{
        return version_compare($this->__toString(), $version, "<");
    }

    public function equals(self $other) : bool{
        return $this->major === $other->major
            && $this->minor === $other->minor
            && $this->patch === $other->patch
            && $this->hotfix === $other->hotfix;
    }

    public function __toString() : string{
        return $this->major . "." . $this->minor . "." . $this->patch . ($this->hotfix > 0 ? "." . $this->hotfix : "");
    }
}
