<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v2193\BossEventCodec;
use Nicholass003\Axiom\Codec\v2193\InventoryTransactionCodec;
use Nicholass003\Axiom\Codec\v2193\MoveActorDeltaCodec;
use Nicholass003\Axiom\Codec\v2193\PlayerAuthInputCodec;
use Nicholass003\Axiom\Codec\v2193\PlaySoundCodec;
use Nicholass003\Axiom\Codec\v2193\RecordStartedCodec;
use Nicholass003\Axiom\Codec\v2193\Serializer\AttributeEnvironmentSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Camera\CameraPresetSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\DimensionDataSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\EntityDiagnosticTimingInfoSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Furnace\FurnaceOptionsSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Inventory\StackResponse\ItemStackResponseSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Inventory\StackResponse\ItemStackResponseSlotInfoSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Inventory\UseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\NoiseAlignmentSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\PlayerAuthInputDataSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Score\ScorePacketEntrySerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\Shape\PrimitiveShapeTextPayloadSerializer;
use Nicholass003\Axiom\Codec\v2193\Serializer\SubChunk\SubChunkPacketHeightMapInfoSerializer;
use Nicholass003\Axiom\Codec\v2193\SetPlayerFurnaceOptionsCodec;
use Nicholass003\Axiom\Data\Type\AttributeEnvironment;
use Nicholass003\Axiom\Data\Type\Camera\CameraPreset;
use Nicholass003\Axiom\Data\Type\DimensionData;
use Nicholass003\Axiom\Data\Type\EntityDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\Furnace\FurnaceOptions;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponse;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Data\Type\NoiseAlignment;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputData;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Data\Type\Shape\PrimitiveShapeTextPayload;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketHeightMapInfo;
use Nicholass003\Axiom\Packet\BossEventPacket;
use Nicholass003\Axiom\Packet\InventoryTransactionPacket;
use Nicholass003\Axiom\Packet\MoveActorDeltaPacket;
use Nicholass003\Axiom\Packet\PlayerAuthInputPacket;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use Nicholass003\Axiom\Packet\RecordStartedPacket;
use Nicholass003\Axiom\Packet\SetPlayerFurnaceOptionsPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol2193 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol2169::buildCodecType()->fork();
        $codec->override(DimensionData::class, new DimensionDataSerializer());
        $codec->override(EntityDiagnosticTimingInfo::class, new EntityDiagnosticTimingInfoSerializer());
        $codec->override(CameraPreset::class, new CameraPresetSerializer());
        $codec->override(SubChunkPacketHeightMapInfo::class, new SubChunkPacketHeightMapInfoSerializer());
        $codec->override(UseItemTransactionData::class, new UseItemTransactionDataSerializer());
        $codec->register(ItemStackResponse::class, new ItemStackResponseSerializer());
        $codec->override(ItemStackResponseSlotInfo::class, new ItemStackResponseSlotInfoSerializer());
        $codec->override(AttributeEnvironment::class, new AttributeEnvironmentSerializer());
        $codec->register(NoiseAlignment::class, new NoiseAlignmentSerializer());
        $codec->register(PrimitiveShapeTextPayload::class, new PrimitiveShapeTextPayloadSerializer());
        $codec->register(FurnaceOptions::class, new FurnaceOptionsSerializer());
        $codec->override(ScorePacketEntry::class, new ScorePacketEntrySerializer());
        $codec->register(PlayerAuthInputData::class, new PlayerAuthInputDataSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol2169::build($mc)->fork(ProtocolVersion::v2193, $mc?->__toString() ?? "1.26.50")
            ->overrideCodecType(self::buildCodecType())
            ->override(BossEventPacket::ID, new BossEventCodec())
            ->override(InventoryTransactionPacket::ID, new InventoryTransactionCodec())
            ->override(MoveActorDeltaPacket::ID, new MoveActorDeltaCodec())
            ->override(PlaySoundPacket::ID, new PlaySoundCodec())
            ->override(PlayerAuthInputPacket::ID, new PlayerAuthInputCodec())
            ->register(RecordStartedPacket::ID, new RecordStartedCodec())
            ->register(SetPlayerFurnaceOptionsPacket::ID, new SetPlayerFurnaceOptionsCodec());
    }
}
