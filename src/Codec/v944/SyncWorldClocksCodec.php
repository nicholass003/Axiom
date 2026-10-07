<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksAddTimeMarker;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksInitializeRegistry;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksRemoveTimeMarker;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksSyncState;
use Nicholass003\Axiom\Enum\SyncWorldClocksType;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\SyncWorldClocksPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClocksCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : SyncWorldClocksPacket{
        $pk = new SyncWorldClocksPacket();
        $typeId = VarInt::readUnsignedInt($in);
        $pk->payload = match($typeId){
            SyncWorldClocksType::SYNC_STATE => $codec->read(SyncWorldClocksSyncState::class, $in),
            SyncWorldClocksType::INITIALIZE_REGISTRY => $codec->read(SyncWorldClocksInitializeRegistry::class, $in),
            SyncWorldClocksType::ADD_TIME_MARKER => $codec->read(SyncWorldClocksAddTimeMarker::class, $in),
            SyncWorldClocksType::REMOVE_TIME_MARKER => $codec->read(SyncWorldClocksRemoveTimeMarker::class, $in),
            default => throw new \RuntimeException("Unknown SyncWorldClocks type: $typeId"),
        };
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof SyncWorldClocksPacket);
        VarInt::writeUnsignedInt($out, $pk->payload->type->value);
        match(true){
            $pk->payload instanceof SyncWorldClocksSyncState => $codec->write(SyncWorldClocksSyncState::class, $out, $pk->payload),
            $pk->payload instanceof SyncWorldClocksInitializeRegistry => $codec->write(SyncWorldClocksInitializeRegistry::class, $out, $pk->payload),
            $pk->payload instanceof SyncWorldClocksAddTimeMarker => $codec->write(SyncWorldClocksAddTimeMarker::class, $out, $pk->payload),
            $pk->payload instanceof SyncWorldClocksRemoveTimeMarker => $codec->write(SyncWorldClocksRemoveTimeMarker::class, $out, $pk->payload),
            default => throw new \RuntimeException("Unknown SyncWorldClocks payload type"),
        };
    }
}
