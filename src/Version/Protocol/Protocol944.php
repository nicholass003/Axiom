<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v944\AddVolumeEntityCodec;
use Nicholass003\Axiom\Codec\v944\AnvilDamageCodec;
use Nicholass003\Axiom\Codec\v944\BlockActorDataCodec;
use Nicholass003\Axiom\Codec\v944\BlockEventCodec;
use Nicholass003\Axiom\Codec\v944\ClientboundAttributeLayerSyncCodec;
use Nicholass003\Axiom\Codec\v944\ClientboundDataDrivenUICloseScreenCodec;
use Nicholass003\Axiom\Codec\v944\ClientboundDataDrivenUIShowScreenCodec;
use Nicholass003\Axiom\Codec\v944\CommandBlockUpdateCodec;
use Nicholass003\Axiom\Codec\v944\ContainerOpenCodec;
use Nicholass003\Axiom\Codec\v944\GraphicsOverrideParameterCodec;
use Nicholass003\Axiom\Codec\v944\LecternUpdateCodec;
use Nicholass003\Axiom\Codec\v944\LocatorBarCodec;
use Nicholass003\Axiom\Codec\v944\OpenSignCodec;
use Nicholass003\Axiom\Codec\v944\PartyChangedCodec;
use Nicholass003\Axiom\Codec\v944\PlayerActionCodec;
use Nicholass003\Axiom\Codec\v944\ResourcePacksReadyForValidationCodec;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeEnvironmentSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeLayerSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeLayerSettingsSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeLayerSettingsWeightFloatSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeLayerSettingsWeightStringSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributesRemoveEnvironmentSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributesUpdateEnvironmentSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeUpdateLayerSettingsSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeUpdateLayersSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeValueBoolSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeValueColorArraySerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeValueColorSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeValueColorStringSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Attribute\AttributeValueFloatSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\CameraFovInstructionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\CameraProgressOptionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\CameraRotationOptionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\CameraSplineInstructionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\LevelSettingsDataSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SubChunk\UpdateSubChunkBlocksPacketEntrySerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClockDataSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClockMarkerDataSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClocksAddTimeMarkerSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClocksInitializeRegistrySerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClocksRemoveTimeMarkerSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClocksSyncStateSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock\SyncWorldClockStateDataSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Voxel\SerializableVoxelShapeSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\WorldPositionSerializer;
use Nicholass003\Axiom\Codec\v944\ServerboundDataDrivenScreenClosedCodec;
use Nicholass003\Axiom\Codec\v944\SetSpawnPositionCodec;
use Nicholass003\Axiom\Codec\v944\StartGameCodec;
use Nicholass003\Axiom\Codec\v944\StructureBlockUpdateCodec;
use Nicholass003\Axiom\Codec\v944\StructureTemplateDataRequestCodec;
use Nicholass003\Axiom\Codec\v944\SyncWorldClocksCodec;
use Nicholass003\Axiom\Codec\v944\UpdateBlockCodec;
use Nicholass003\Axiom\Codec\v944\UpdateClientInputLocksCodec;
use Nicholass003\Axiom\Codec\v944\UpdateSubChunkBlocksCodec;
use Nicholass003\Axiom\Codec\v944\VoxelShapesCodec;
use Nicholass003\Axiom\Data\Type\AttributeEnvironment;
use Nicholass003\Axiom\Data\Type\AttributeLayer;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettings;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettingsWeightFloat;
use Nicholass003\Axiom\Data\Type\AttributeLayerSettingsWeightString;
use Nicholass003\Axiom\Data\Type\AttributesRemoveEnvironment;
use Nicholass003\Axiom\Data\Type\AttributesUpdateEnvironment;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayers;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayerSettings;
use Nicholass003\Axiom\Data\Type\AttributeValueBool;
use Nicholass003\Axiom\Data\Type\AttributeValueColor;
use Nicholass003\Axiom\Data\Type\AttributeValueColorArray;
use Nicholass003\Axiom\Data\Type\AttributeValueColorString;
use Nicholass003\Axiom\Data\Type\AttributeValueFloat;
use Nicholass003\Axiom\Data\Type\Camera\CameraFovInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Data\Type\LevelSettingsData;
use Nicholass003\Axiom\Data\Type\SerializableVoxelShape;
use Nicholass003\Axiom\Data\Type\SubChunk\UpdateSubChunkBlocksPacketEntry;
use Nicholass003\Axiom\Data\Type\SyncWorldClockData;
use Nicholass003\Axiom\Data\Type\SyncWorldClockMarkerData;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksAddTimeMarker;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksInitializeRegistry;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksRemoveTimeMarker;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksSyncState;
use Nicholass003\Axiom\Data\Type\SyncWorldClockStateData;
use Nicholass003\Axiom\Data\Type\WorldPosition;
use Nicholass003\Axiom\Packet\AddVolumeEntityPacket;
use Nicholass003\Axiom\Packet\AnvilDamagePacket;
use Nicholass003\Axiom\Packet\BlockActorDataPacket;
use Nicholass003\Axiom\Packet\BlockEventPacket;
use Nicholass003\Axiom\Packet\ClientboundAttributeLayerSyncPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUICloseScreenPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUIShowScreenPacket;
use Nicholass003\Axiom\Packet\CommandBlockUpdatePacket;
use Nicholass003\Axiom\Packet\ContainerOpenPacket;
use Nicholass003\Axiom\Packet\GraphicsOverrideParameterPacket;
use Nicholass003\Axiom\Packet\LecternUpdatePacket;
use Nicholass003\Axiom\Packet\LocatorBarPacket;
use Nicholass003\Axiom\Packet\OpenSignPacket;
use Nicholass003\Axiom\Packet\PartyChangedPacket;
use Nicholass003\Axiom\Packet\PlayerActionPacket;
use Nicholass003\Axiom\Packet\ResourcePacksReadyForValidationPacket;
use Nicholass003\Axiom\Packet\ServerboundDataDrivenScreenClosedPacket;
use Nicholass003\Axiom\Packet\SetSpawnPositionPacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\StructureBlockUpdatePacket;
use Nicholass003\Axiom\Packet\StructureTemplateDataRequestPacket;
use Nicholass003\Axiom\Packet\SyncWorldClocksPacket;
use Nicholass003\Axiom\Packet\UpdateBlockPacket;
use Nicholass003\Axiom\Packet\UpdateClientInputLocksPacket;
use Nicholass003\Axiom\Packet\UpdateSubChunkBlocksPacket;
use Nicholass003\Axiom\Packet\VoxelShapesPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol944 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol924::buildCodecType()->fork();
        $codec->override(SerializableVoxelShape::class, new SerializableVoxelShapeSerializer());
        $codec->override(CameraFovInstruction::class, new CameraFovInstructionSerializer());
        $codec->override(CameraProgressOption::class, new CameraProgressOptionSerializer());
        $codec->override(CameraRotationOption::class, new CameraRotationOptionSerializer());
        $codec->override(CameraSplineInstruction::class, new CameraSplineInstructionSerializer());
        $codec->override(LevelSettingsData::class, new LevelSettingsDataSerializer());
        $codec->override(UpdateSubChunkBlocksPacketEntry::class, new UpdateSubChunkBlocksPacketEntrySerializer());
        $codec->register(WorldPosition::class, new WorldPositionSerializer());
        $codec->register(SyncWorldClockData::class, new SyncWorldClockDataSerializer());
        $codec->register(SyncWorldClockMarkerData::class, new SyncWorldClockMarkerDataSerializer());
        $codec->register(SyncWorldClockStateData::class, new SyncWorldClockStateDataSerializer());
        $codec->register(SyncWorldClocksAddTimeMarker::class, new SyncWorldClocksAddTimeMarkerSerializer());
        $codec->register(SyncWorldClocksInitializeRegistry::class, new SyncWorldClocksInitializeRegistrySerializer());
        $codec->register(SyncWorldClocksRemoveTimeMarker::class, new SyncWorldClocksRemoveTimeMarkerSerializer());
        $codec->register(SyncWorldClocksSyncState::class, new SyncWorldClocksSyncStateSerializer());
        $codec->register(AttributeLayerSettings::class, new AttributeLayerSettingsSerializer());
        $codec->register(AttributeLayerSettingsWeightFloat::class, new AttributeLayerSettingsWeightFloatSerializer());
        $codec->register(AttributeLayerSettingsWeightString::class, new AttributeLayerSettingsWeightStringSerializer());
        $codec->register(AttributeLayer::class, new AttributeLayerSerializer());
        $codec->register(AttributeEnvironment::class, new AttributeEnvironmentSerializer());
        $codec->register(AttributeUpdateLayerSettings::class, new AttributeUpdateLayerSettingsSerializer());
        $codec->register(AttributeUpdateLayers::class, new AttributeUpdateLayersSerializer());
        $codec->register(AttributeValueBool::class, new AttributeValueBoolSerializer());
        $codec->register(AttributeValueColor::class, new AttributeValueColorSerializer());
        $codec->register(AttributeValueColorArray::class, new AttributeValueColorArraySerializer());
        $codec->register(AttributeValueColorString::class, new AttributeValueColorStringSerializer());
        $codec->register(AttributeValueFloat::class, new AttributeValueFloatSerializer());
        $codec->register(AttributesRemoveEnvironment::class, new AttributesRemoveEnvironmentSerializer());
        $codec->register(AttributesUpdateEnvironment::class, new AttributesUpdateEnvironmentSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol924::build()->fork(ProtocolVersion::v944, $mc?->__toString() ?? "1.26.10")
            ->register(ResourcePacksReadyForValidationPacket::ID, new ResourcePacksReadyForValidationCodec())
            ->register(LocatorBarPacket::ID, new LocatorBarCodec())
            ->register(PartyChangedPacket::ID, new PartyChangedCodec())
            ->register(ServerboundDataDrivenScreenClosedPacket::ID, new ServerboundDataDrivenScreenClosedCodec())
            ->register(SyncWorldClocksPacket::ID, new SyncWorldClocksCodec())
            ->register(ClientboundAttributeLayerSyncPacket::ID, new ClientboundAttributeLayerSyncCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(UpdateBlockPacket::ID, new UpdateBlockCodec())
            ->override(BlockEventPacket::ID, new BlockEventCodec())
            ->override(PlayerActionPacket::ID, new PlayerActionCodec())
            ->override(SetSpawnPositionPacket::ID, new SetSpawnPositionCodec())
            ->override(ContainerOpenPacket::ID, new ContainerOpenCodec())
            ->override(BlockActorDataPacket::ID, new BlockActorDataCodec())
            ->override(CommandBlockUpdatePacket::ID, new CommandBlockUpdateCodec())
            ->override(StructureBlockUpdatePacket::ID, new StructureBlockUpdateCodec())
            ->override(LecternUpdatePacket::ID, new LecternUpdateCodec())
            ->override(StructureTemplateDataRequestPacket::ID, new StructureTemplateDataRequestCodec())
            ->override(AnvilDamagePacket::ID, new AnvilDamageCodec())
            ->override(AddVolumeEntityPacket::ID, new AddVolumeEntityCodec())
            ->override(UpdateSubChunkBlocksPacket::ID, new UpdateSubChunkBlocksCodec())
            ->override(UpdateClientInputLocksPacket::ID, new UpdateClientInputLocksCodec())
            ->override(OpenSignPacket::ID, new OpenSignCodec())
            ->override(GraphicsOverrideParameterPacket::ID, new GraphicsOverrideParameterCodec())
            ->override(ClientboundDataDrivenUIShowScreenPacket::ID, new ClientboundDataDrivenUIShowScreenCodec())
            ->override(ClientboundDataDrivenUICloseScreenPacket::ID, new ClientboundDataDrivenUICloseScreenCodec())
            ->override(VoxelShapesPacket::ID, new VoxelShapesCodec());
    }
}
