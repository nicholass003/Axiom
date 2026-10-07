<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreChange;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreRemoval;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Enum\DataStoreType;
use Nicholass003\Axiom\Packet\ClientboundDataStorePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ClientboundDataStoreCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientboundDataStorePacket{
        $pk = new ClientboundDataStorePacket();

        $count = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $type = DataStoreType::safe(VarInt::readUnsignedInt($in));
            $pk->values[] = match($type){
                DataStoreType::UPDATE => $codec->read(DataStoreUpdate::class, $in),
                DataStoreType::CHANGE => $codec->read(DataStoreChange::class, $in),
                DataStoreType::REMOVAL => $codec->read(DataStoreRemoval::class, $in),
                default => throw new \RuntimeException("Unknown DataStore type $type->value")
            };
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundDataStorePacket);

        VarInt::writeUnsignedInt($out, count($pk->values));
        foreach($pk->values as $value){
            VarInt::writeUnsignedInt($out, $value->type->value);
            $codec->write($value::class, $out, $value);
        }
    }
}
