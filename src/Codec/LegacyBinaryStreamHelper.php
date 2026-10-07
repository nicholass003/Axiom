<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec;

use pmmp\encoding\BE;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use function strlen;

/** @since v41 */
final class LegacyBinaryStreamHelper{

    private function __construct(){}

    public static function readString(ByteBufferReader $in) : string{
        $len = BE::readSignedShort($in);
        return $in->readByteArray($len);
    }
    public static function writeString(ByteBufferWriter $out, string $value) : void{
        BE::writeSignedShort($out, strlen($value));
        $out->writeByteArray($value);
    }

    public static function readInt(ByteBufferReader $in) : int{
        return BE::readSignedInt($in);
    }
    public static function writeInt(ByteBufferWriter $out, int $value) : void{
        BE::writeSignedInt($out, $value);
    }

    public static function readLong(ByteBufferReader $in) : int{
        return BE::readSignedLong($in);
    }
    public static function writeLong(ByteBufferWriter $out, int $value) : void{
        BE::writeSignedLong($out, $value);
    }

    public static function readShort(ByteBufferReader $in) : int{
        return BE::readSignedShort($in);
    }
    public static function writeShort(ByteBufferWriter $out, int $value) : void{
        BE::writeSignedShort($out, $value);
    }

    public static function readByte(ByteBufferReader $in) : int{
        return Byte::readUnsigned($in);
    }
    public static function writeByte(ByteBufferWriter $out, int $value) : void{
        Byte::writeUnsigned($out, $value);
    }

    public static function readLInt(ByteBufferReader $in) : int{
        return LE::readSignedInt($in);
    }
    public static function writeLInt(ByteBufferWriter $out, int $value) : void{
        LE::writeSignedInt($out, $value);
    }

    public static function readLShort(ByteBufferReader $in) : int{
        return LE::readSignedShort($in);
    }
    public static function writeLShort(ByteBufferWriter $out, int $value) : void{
        LE::writeSignedShort($out, $value);
    }

    public static function readFloat(ByteBufferReader $in) : float{
        return BE::readFloat($in);
    }
    public static function writeFloat(ByteBufferWriter $out, float $value) : void{
        BE::writeFloat($out, $value);
    }

    public static function readLFloat(ByteBufferReader $in) : float{
        return LE::readFloat($in);
    }
    public static function writeLFloat(ByteBufferWriter $out, float $value) : void{
        LE::writeFloat($out, $value);
    }

    public static function readTriad(ByteBufferReader $in) : int{
        return BE::readUnsignedTriad($in);
    }
    public static function writeTriad(ByteBufferWriter $out, int $value) : void{
        BE::writeUnsignedTriad($out, $value);
    }

    public static function readLTriad(ByteBufferReader $in) : int{
        return LE::readUnsignedTriad($in);
    }
    public static function writeLTriad(ByteBufferWriter $out, int $value) : void{
        LE::writeUnsignedTriad($out, $value);
    }

    public static function readUUID(ByteBufferReader $in) : string{
        return $in->readByteArray(16);
    }
    public static function writeUUID(ByteBufferWriter $out, string $uuid) : void{
        $out->writeByteArray($uuid);
    }

    public static function readItem(ByteBufferReader $in) : array{
        $id = self::readShort($in);
        if($id <= 0){
            return ['id' => 0, 'count' => 0, 'damage' => 0, 'nbt' => ''];
        }
        $count = self::readByte($in);
        $damage = self::readShort($in);
        $nbtLen = self::readShort($in);
        $nbt = $nbtLen > 0 ? $in->readByteArray($nbtLen) : '';
        return ['id' => $id, 'count' => $count, 'damage' => $damage, 'nbt' => $nbt];
    }
    public static function writeItem(ByteBufferWriter $out, array $item) : void{
        if($item['id'] <= 0){
            self::writeShort($out, 0);
            return;
        }
        self::writeShort($out, $item['id']);
        self::writeByte($out, $item['count']);
        self::writeShort($out, $item['damage']);
        self::writeShort($out, strlen($item['nbt']));
        if(strlen($item['nbt']) > 0){
            $out->writeByteArray($item['nbt']);
        }
    }

    public static function readMetadata(ByteBufferReader $in) : string{
        return $in->readByteArray($in->getUnreadLength());
    }
    public static function writeMetadata(ByteBufferWriter $out, string $metadata) : void{
        $out->writeByteArray($metadata);
    }
}
