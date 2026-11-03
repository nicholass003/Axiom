<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v924\BookEditCodec;
use Nicholass003\Axiom\Codec\v924\CameraAimAssistActorPriorityCodec;
use Nicholass003\Axiom\Codec\v924\CameraSplineCodec;
use Nicholass003\Axiom\Codec\v924\ClientboundDataDrivenUICloseScreenCodec;
use Nicholass003\Axiom\Codec\v924\ClientboundDataDrivenUIReloadCodec;
use Nicholass003\Axiom\Codec\v924\ClientboundDataDrivenUIShowScreenCodec;
use Nicholass003\Axiom\Codec\v924\ClientboundDataStoreCodec;
use Nicholass003\Axiom\Codec\v924\ClientboundTextureShiftCodec;
use Nicholass003\Axiom\Codec\v924\GraphicsOverrideParameterCodec;
use Nicholass003\Axiom\Codec\v924\Serializer\Biome\BiomeDefinitionChunkGenDataSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraAimAssistActorPrioritySerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraAimAssistCategoryPrioritySerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraAimAssistCategorySerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraAimAssistPresetExclusionDefinitionSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraProgressOptionSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraRotationOptionSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Camera\CameraSplineInstructionSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\DataStore\DataStoreChangeSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\DataStore\DataStoreUpdateSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Debug\PacketShapeDataSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\GatheringJoinInfoSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\LevelSettingsDataSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\MemoryCategoryCounterSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\ServerJoinInformationSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\ServerTelemetryDataSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Voxel\SerializableVoxelCellsSerializer;
use Nicholass003\Axiom\Codec\v924\Serializer\Voxel\SerializableVoxelShapeSerializer;
use Nicholass003\Axiom\Codec\v924\ServerboundDiagnosticsCodec;
use Nicholass003\Axiom\Codec\v924\StartGameCodec;
use Nicholass003\Axiom\Codec\v924\TextCodec;
use Nicholass003\Axiom\Codec\v924\VoxelShapesCodec;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistActorPriority;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryPriority;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetExclusionDefinition;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreChange;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Data\Type\Debug\PacketShapeData;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use Nicholass003\Axiom\Data\Type\LevelSettingsData;
use Nicholass003\Axiom\Data\Type\MemoryCategoryCounter;
use Nicholass003\Axiom\Data\Type\SerializableVoxelCells;
use Nicholass003\Axiom\Data\Type\SerializableVoxelShape;
use Nicholass003\Axiom\Data\Type\ServerJoinInformation;
use Nicholass003\Axiom\Data\Type\ServerTelemetryData;
use Nicholass003\Axiom\Packet\BookEditPacket;
use Nicholass003\Axiom\Packet\CameraAimAssistActorPriorityPacket;
use Nicholass003\Axiom\Packet\CameraSplinePacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUICloseScreenPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUIReloadPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUIShowScreenPacket;
use Nicholass003\Axiom\Packet\ClientboundDataStorePacket;
use Nicholass003\Axiom\Packet\ClientboundTextureShiftPacket;
use Nicholass003\Axiom\Packet\GraphicsOverrideParameterPacket;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\TextPacket;
use Nicholass003\Axiom\Packet\VoxelShapesPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol924 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol898::buildCodecType()->fork();
        $codec->override(CameraAimAssistCategory::class, new CameraAimAssistCategorySerializer());
        $codec->override(CameraAimAssistPresetExclusionDefinition::class, new CameraAimAssistPresetExclusionDefinitionSerializer());
        $codec->override(CameraProgressOption::class, new CameraProgressOptionSerializer());
        $codec->override(CameraRotationOption::class, new CameraRotationOptionSerializer());
        $codec->override(CameraSplineInstruction::class, new CameraSplineInstructionSerializer());
        $codec->override(LevelSettingsData::class, new LevelSettingsDataSerializer());
        $codec->override(BiomeDefinitionChunkGenData::class, new BiomeDefinitionChunkGenDataSerializer());
        $codec->override(PacketShapeData::class, new PacketShapeDataSerializer());
        $codec->override(DataStoreUpdate::class, new DataStoreUpdateSerializer());
        $codec->override(DataStoreChange::class, new DataStoreChangeSerializer());
        $codec->register(CameraAimAssistActorPriority::class, new CameraAimAssistActorPrioritySerializer());
        $codec->register(CameraAimAssistCategoryPriority::class, new CameraAimAssistCategoryPrioritySerializer());
        $codec->register(GatheringJoinInfo::class, new GatheringJoinInfoSerializer());
        $codec->register(MemoryCategoryCounter::class, new MemoryCategoryCounterSerializer());
        $codec->register(ServerJoinInformation::class, new ServerJoinInformationSerializer());
        $codec->register(ServerTelemetryData::class, new ServerTelemetryDataSerializer());
        $codec->register(SerializableVoxelCells::class, new SerializableVoxelCellsSerializer());
        $codec->register(SerializableVoxelShape::class, new SerializableVoxelShapeSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol898::build()->fork(ProtocolVersion::v924, $mc?->__toString() ?? "1.26.0")
            ->register(ClientboundDataDrivenUIShowScreenPacket::ID, new ClientboundDataDrivenUIShowScreenCodec())
            ->register(ClientboundDataDrivenUICloseScreenPacket::ID, new ClientboundDataDrivenUICloseScreenCodec())
            ->register(ClientboundDataDrivenUIReloadPacket::ID, new ClientboundDataDrivenUIReloadCodec())
            ->register(ClientboundTextureShiftPacket::ID, new ClientboundTextureShiftCodec())
            ->register(VoxelShapesPacket::ID, new VoxelShapesCodec())
            ->register(CameraSplinePacket::ID, new CameraSplineCodec())
            ->register(CameraAimAssistActorPriorityPacket::ID, new CameraAimAssistActorPriorityCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(TextPacket::ID, new TextCodec())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(BookEditPacket::ID, new BookEditCodec())
            ->override(ServerboundDiagnosticsPacket::ID, new ServerboundDiagnosticsCodec())
            ->override(ClientboundDataStorePacket::ID, new ClientboundDataStoreCodec())
            ->override(GraphicsOverrideParameterPacket::ID, new GraphicsOverrideParameterCodec());
    }
}
