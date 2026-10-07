<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v898\AnimateCodec;
use Nicholass003\Axiom\Codec\v898\AvailableCommandsCodec;
use Nicholass003\Axiom\Codec\v898\ClientboundDataStoreCodec;
use Nicholass003\Axiom\Codec\v898\ClientboundDebugRendererCodec;
use Nicholass003\Axiom\Codec\v898\CommandOutputCodec;
use Nicholass003\Axiom\Codec\v898\CommandRequestCodec;
use Nicholass003\Axiom\Codec\v898\InteractCodec;
use Nicholass003\Axiom\Codec\v898\MobEffectCodec;
use Nicholass003\Axiom\Codec\v898\ResourcePackStackCodec;
use Nicholass003\Axiom\Codec\v898\Serializer\Camera\CameraAimAssistCategorySerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Camera\CameraAimAssistPresetExclusionDefinitionSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Camera\CameraAimAssistPresetSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\ChainedSubCommandDataSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\ChainedSubCommandValueSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\CommandDataSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\CommandEnumSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\CommandOriginDataSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Command\CommandOutputMessageSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\BoolDataStoreValueSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\DataStoreChangeSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\DataStoreRemovalSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\DataStoreUpdateSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\DoubleDataStoreValueSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\DataStore\StringDataStoreValueSerializer;
use Nicholass003\Axiom\Codec\v898\Serializer\Debug\DebugMarkerDataSerializer;
use Nicholass003\Axiom\Codec\v898\ServerboundDataStoreCodec;
use Nicholass003\Axiom\Codec\v898\StartGameCodec;
use Nicholass003\Axiom\Codec\v898\TextCodec;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPreset;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetExclusionDefinition;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandRawData;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandValueRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Data\Type\Command\CommandOutputMessage;
use Nicholass003\Axiom\Data\Type\Command\CommandRawData;
use Nicholass003\Axiom\Data\Type\DataStore\BoolDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreChange;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreRemoval;
use Nicholass003\Axiom\Data\Type\DataStore\DataStoreUpdate;
use Nicholass003\Axiom\Data\Type\DataStore\DoubleDataStoreValue;
use Nicholass003\Axiom\Data\Type\DataStore\StringDataStoreValue;
use Nicholass003\Axiom\Data\Type\Debug\DebugMarkerData;
use Nicholass003\Axiom\Packet\AnimatePacket;
use Nicholass003\Axiom\Packet\AvailableCommandsPacket;
use Nicholass003\Axiom\Packet\ClientboundDataStorePacket;
use Nicholass003\Axiom\Packet\ClientboundDebugRendererPacket;
use Nicholass003\Axiom\Packet\CommandOutputPacket;
use Nicholass003\Axiom\Packet\CommandRequestPacket;
use Nicholass003\Axiom\Packet\InteractPacket;
use Nicholass003\Axiom\Packet\MobEffectPacket;
use Nicholass003\Axiom\Packet\ResourcePackStackPacket;
use Nicholass003\Axiom\Packet\ServerboundDataStorePacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\TextPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol898 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol860::buildCodecType()->fork();
        $codec->override(CommandOriginData::class, new CommandOriginDataSerializer());
        $codec->override(CommandOutputMessage::class, new CommandOutputMessageSerializer());
        $codec->override(CommandEnumRawData::class, new CommandEnumSerializer());
        $codec->override(ChainedSubCommandValueRawData::class, new ChainedSubCommandValueSerializer());
        $codec->override(ChainedSubCommandRawData::class, new ChainedSubCommandDataSerializer());
        $codec->override(CommandRawData::class, new CommandDataSerializer());
        $codec->override(DebugMarkerData::class, new DebugMarkerDataSerializer());
        $codec->override(CameraAimAssistPresetExclusionDefinition::class, new CameraAimAssistPresetExclusionDefinitionSerializer());
        $codec->override(CameraAimAssistCategory::class, new CameraAimAssistCategorySerializer());
        $codec->override(CameraAimAssistPreset::class, new CameraAimAssistPresetSerializer());
        $codec->override(DataStoreUpdate::class, new DataStoreUpdateSerializer());
        $codec->override(DataStoreChange::class, new DataStoreChangeSerializer());
        $codec->override(DataStoreRemoval::class, new DataStoreRemovalSerializer());
        $codec->override(DoubleDataStoreValue::class, new DoubleDataStoreValueSerializer());
        $codec->override(BoolDataStoreValue::class, new BoolDataStoreValueSerializer());
        $codec->override(StringDataStoreValue::class, new StringDataStoreValueSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol860::build()->fork(ProtocolVersion::v898, $mc?->__toString() ?? "1.21.130")
            ->register(ServerboundDataStorePacket::ID, new ServerboundDataStoreCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(ResourcePackStackPacket::ID, new ResourcePackStackCodec())
            ->override(TextPacket::ID, new TextCodec())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(MobEffectPacket::ID, new MobEffectCodec())
            ->override(InteractPacket::ID, new InteractCodec())
            ->override(AnimatePacket::ID, new AnimateCodec())
            ->override(AvailableCommandsPacket::ID, new AvailableCommandsCodec())
            ->override(CommandOutputPacket::ID, new CommandOutputCodec())
            ->override(CommandRequestPacket::ID, new CommandRequestCodec())
            ->override(ClientboundDebugRendererPacket::ID, new ClientboundDebugRendererCodec())
            ->override(ClientboundDataStorePacket::ID, new ClientboundDataStoreCodec());
    }
}
