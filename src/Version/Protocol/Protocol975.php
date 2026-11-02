<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v975\ActorEventCodec;
use Nicholass003\Axiom\Codec\v975\ClientMovementPredictionSyncCodec;
use Nicholass003\Axiom\Codec\v975\DisconnectCodec;
use Nicholass003\Axiom\Codec\v975\InventorySlotCodec;
use Nicholass003\Axiom\Codec\v975\LevelSoundEventCodec;
use Nicholass003\Axiom\Codec\v975\MobEquipmentCodec;
use Nicholass003\Axiom\Codec\v975\PartyChangedCodec;
use Nicholass003\Axiom\Codec\v975\PlaySoundCodec;
use Nicholass003\Axiom\Codec\v975\Serializer\ClientStoreEntrypointConfigSerializer;
use Nicholass003\Axiom\Codec\v975\Serializer\EntityDiagnosticTimingInfoSerializer;
use Nicholass003\Axiom\Codec\v975\Serializer\ItemStackWrapperSerializer;
use Nicholass003\Axiom\Codec\v975\Serializer\PresenceConfigSerializer;
use Nicholass003\Axiom\Codec\v975\Serializer\Recipe\RecipeWithTypeIdSerializer;
use Nicholass003\Axiom\Codec\v975\Serializer\SystemDiagnosticTimingInfoSerializer;
use Nicholass003\Axiom\Codec\v975\ServerboundDiagnosticsCodec;
use Nicholass003\Axiom\Codec\v975\ServerPresenceInfoCodec;
use Nicholass003\Axiom\Codec\v975\ServerStoreInfoCodec;
use Nicholass003\Axiom\Codec\v975\UpdateClientOptionsCodec;
use Nicholass003\Axiom\Data\Type\ClientStoreEntrypointConfig;
use Nicholass003\Axiom\Data\Type\EntityDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\PresenceConfig;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Data\Type\SystemDiagnosticTimingInfo;
use Nicholass003\Axiom\Packet\ActorEventPacket;
use Nicholass003\Axiom\Packet\ClientMovementPredictionSyncPacket;
use Nicholass003\Axiom\Packet\DisconnectPacket;
use Nicholass003\Axiom\Packet\InventorySlotPacket;
use Nicholass003\Axiom\Packet\LevelSoundEventPacket;
use Nicholass003\Axiom\Packet\MobEquipmentPacket;
use Nicholass003\Axiom\Packet\PartyChangedPacket;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use Nicholass003\Axiom\Packet\ServerPresenceInfoPacket;
use Nicholass003\Axiom\Packet\ServerStoreInfoPacket;
use Nicholass003\Axiom\Packet\UpdateClientOptionsPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol975 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol944::buildCodecType()->fork();
        $codec->register(PresenceConfig::class, new PresenceConfigSerializer());
        $codec->register(ClientStoreEntrypointConfig::class, new ClientStoreEntrypointConfigSerializer());
        $codec->register(EntityDiagnosticTimingInfo::class, new EntityDiagnosticTimingInfoSerializer());
        $codec->register(SystemDiagnosticTimingInfo::class, new SystemDiagnosticTimingInfoSerializer());
        $codec->override(ItemStackWrapper::class, new ItemStackWrapperSerializer());
        $codec->override(RecipeWithTypeId::class, new RecipeWithTypeIdSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol944::build()->fork(ProtocolVersion::v975, $mc?->__toString() ?? "1.26.20")
            ->register(ServerStoreInfoPacket::ID, new ServerStoreInfoCodec())
            ->register(ServerPresenceInfoPacket::ID, new ServerPresenceInfoCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(DisconnectPacket::ID, new DisconnectCodec())
            ->override(ActorEventPacket::ID, new ActorEventCodec())
            ->override(MobEquipmentPacket::ID, new MobEquipmentCodec())
            ->override(InventorySlotPacket::ID, new InventorySlotCodec())
            ->override(PlaySoundPacket::ID, new PlaySoundCodec())
            ->override(LevelSoundEventPacket::ID, new LevelSoundEventCodec())
            ->override(ServerboundDiagnosticsPacket::ID, new ServerboundDiagnosticsCodec())
            ->override(ClientMovementPredictionSyncPacket::ID, new ClientMovementPredictionSyncCodec())
            ->override(UpdateClientOptionsPacket::ID, new UpdateClientOptionsCodec())
            ->override(PartyChangedPacket::ID, new PartyChangedCodec());
    }
}
