<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v41;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\LegacyBinaryStreamHelper as Binary;
use Nicholass003\Axiom\Packet\Legacy\LoginPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

/** @since v41 */
class LoginCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : LoginPacket{
        $pk = new LoginPacket();
        $pk->username = Binary::readString($in);
        $pk->protocol1 = Binary::readInt($in);
        $pk->protocol2 = Binary::readInt($in);
        $pk->clientId = Binary::readLong($in);
        $pk->clientUUID = Binary::readUUID($in);
        $pk->serverAddress = Binary::readString($in);
        $pk->clientSecret = Binary::readString($in);
        $pk->skinName = Binary::readString($in);
        $pk->skin = Binary::readString($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof LoginPacket);
        Binary::writeString($out, $pk->username);
        Binary::writeInt($out, $pk->protocol1);
        Binary::writeInt($out, $pk->protocol2);
        Binary::writeLong($out, $pk->clientId);
        Binary::writeUUID($out, $pk->clientUUID);
        Binary::writeString($out, $pk->serverAddress);
        Binary::writeString($out, $pk->clientSecret);
        Binary::writeString($out, $pk->skinName);
        Binary::writeString($out, $pk->skin);
    }
}
