<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v41;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\LegacyBinaryStreamHelper as Binary;
use Nicholass003\Axiom\Packet\Legacy\TextPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

/** @since v41 */
class TextCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : TextPacket{
        $pk = new TextPacket();
        $pk->type = Binary::readByte($in);
        switch($pk->type){
            case TextPacket::TYPE_POPUP:
            case TextPacket::TYPE_CHAT:
                $pk->source = Binary::readString($in);
            case TextPacket::TYPE_RAW:
            case TextPacket::TYPE_TIP:
            case TextPacket::TYPE_SYSTEM:
                $pk->message = Binary::readString($in);
                break;
            case TextPacket::TYPE_TRANSLATION:
                $pk->message = Binary::readString($in);
                $count = Binary::readByte($in);
                for($i = 0; $i < $count; ++$i){
                    $pk->parameters[] = Binary::readString($in);
                }
                break;
        }
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof TextPacket);
        Binary::writeByte($out, $pk->type);
        switch($pk->type){
            case TextPacket::TYPE_POPUP:
            case TextPacket::TYPE_CHAT:
                Binary::writeString($out, $pk->source);
            case TextPacket::TYPE_RAW:
            case TextPacket::TYPE_TIP:
            case TextPacket::TYPE_SYSTEM:
                Binary::writeString($out, $pk->message);
                break;
            case TextPacket::TYPE_TRANSLATION:
                Binary::writeString($out, $pk->message);
                Binary::writeByte($out, count($pk->parameters));
                foreach($pk->parameters as $p){
                    Binary::writeString($out, $p);
                }
                break;
        }
    }
}
