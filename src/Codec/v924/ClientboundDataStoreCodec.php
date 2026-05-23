<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v898\ClientboundDataStoreCodec as V898ClientboundDataStoreCodec;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Enum\DataStoreType;
use Nicholass003\Axiom\Packet\ClientboundDataStorePacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ClientboundDataStoreCodec extends V898ClientboundDataStoreCodec{

    public function decode(ByteBufferReader $in, CodecType $codec) : Packet{
        $pk = new ClientboundDataStorePacket();

        $count = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $count; ++$i){
            $type = VarInt::readUnsignedInt($in);
            $pk->values[] = $this->readDataStore($in, DataStoreType::safe($type));
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundDataStorePacket);

        VarInt::writeUnsignedInt($out, count($pk->values));
        foreach($pk->values as $value){
            VarInt::writeUnsignedInt($out, $this->getDataStoreType($value)->value);
            $this->writeDataStore($out, $value);
        }
    }

    protected function readUpdate(ByteBufferReader $in) : DataStoreUpdate{
        $name = CodecHelper::readString($in);
        $property = CodecHelper::readString($in);
        $path = CodecHelper::readString($in);
        $data = $this->readDataStoreValue($in);
        $updateCount = LE::readUnsignedInt($in);
        $pathUpdateCount = LE::readUnsignedInt($in);

        return new DataStoreUpdate($name, $property, $path, $data, $updateCount, $pathUpdateCount);
    }

    protected function writeUpdate(ByteBufferWriter $out, DataStoreUpdate $update) : void{
        CodecHelper::writeString($out, $update->name);
        CodecHelper::writeString($out, $update->property);
        CodecHelper::writeString($out, $update->path);
        $this->writeDataStoreValue($out, $update->data);
        LE::writeUnsignedInt($out, $update->updateCount);
        LE::writeUnsignedInt($out, $update->pathUpdateCount);
    }
}
