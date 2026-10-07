<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use function strlen;

/** @since v41 */
class LegacyCodecHelper{

    private function __construct(){}

    public static function readStringLE(ByteBufferReader $in) : string{
        $len = LE::readUnsignedInt($in);
        return $in->readByteArray($len);
    }

    public static function writeStringLE(ByteBufferWriter $out, string $value) : void{
        LE::writeUnsignedInt($out, strlen($value));
        $out->writeByteArray($value);
    }

    public static function readUUID(ByteBufferReader $in) : string{
        return $in->readByteArray(16);
    }

    public static function writeUUID(ByteBufferWriter $out, string $uuid) : void{
        $out->writeByteArray($uuid);
    }
}
