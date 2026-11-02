<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Enum\ResourcePackClientResponseStatus;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ResourcePackClientResponsePacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;
use UnexpectedValueException;
use function count;

class ResourcePackClientResponseCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ResourcePackClientResponsePacket{
        $pk = new ResourcePackClientResponsePacket();
        $pk->status = ResourcePackClientResponseStatus::fromOrdinal(VarInt::readUnsignedInt($in));
        $innerType = CodecHelper::readString($in);
        if($innerType !== $pk->status->value){
            throw new UnexpectedValueException("Unexpected inner type $innerType for resource pack client response status, expected " . $pk->status->value);
        }

        if($pk->status === ResourcePackClientResponseStatus::STATUS_SEND_PACKS){
            $count = VarInt::readUnsignedInt($in);
            for($i = 0; $i < $count; $i++){
                $pk->packIds[] = CodecHelper::readString($in);
            }
        }
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ResourcePackClientResponsePacket);
        VarInt::writeUnsignedInt($out, $pk->status->toOrdinal());
        CodecHelper::writeString($out, $pk->status->value);
        if($pk->status === ResourcePackClientResponseStatus::STATUS_SEND_PACKS){
            VarInt::writeUnsignedInt($out, count($pk->packIds));
            foreach($pk->packIds as $id){
                CodecHelper::writeString($out, $id);
            }
        }
    }
}
