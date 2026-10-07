<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v1001\BossEventCodec;
use Nicholass003\Axiom\Codec\v1001\ClientboundUpdateSoundDataCodec;
use Nicholass003\Axiom\Codec\v1001\GraphicsOverrideParameterCodec;
use Nicholass003\Axiom\Codec\v1001\InventoryContentCodec;
use Nicholass003\Axiom\Codec\v1001\InventoryTransactionCodec;
use Nicholass003\Axiom\Codec\v1001\LevelSoundEventCodec;
use Nicholass003\Axiom\Codec\v1001\MobArmorEquipmentCodec;
use Nicholass003\Axiom\Codec\v1001\PartyDestinationCookieResponseCodec;
use Nicholass003\Axiom\Codec\v1001\SendPartyDestinationCookieCodec;
use Nicholass003\Axiom\Codec\v1001\Serializer\Inventory\InventoryTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\Inventory\NetworkInventoryActionSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\Inventory\ReleaseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\Inventory\UseItemOnEntityTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\Inventory\UseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\LevelSettingsDataSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\PresenceConfigSerializer;
use Nicholass003\Axiom\Codec\v1001\Serializer\WhiskerScopeDataSummarySerializer;
use Nicholass003\Axiom\Codec\v1001\ServerboundDiagnosticsCodec;
use Nicholass003\Axiom\Codec\v1001\ServerPresenceInfoCodec;
use Nicholass003\Axiom\Codec\v1001\StartGameCodec;
use Nicholass003\Axiom\Codec\v1001\SubChunkRequestCodec;
use Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction;
use Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Data\Type\LevelSettingsData;
use Nicholass003\Axiom\Data\Type\PresenceConfig;
use Nicholass003\Axiom\Data\Type\WhiskerScopeDataSummary;
use Nicholass003\Axiom\Packet\BossEventPacket;
use Nicholass003\Axiom\Packet\ClientboundUpdateSoundDataPacket;
use Nicholass003\Axiom\Packet\GraphicsOverrideParameterPacket;
use Nicholass003\Axiom\Packet\InventoryContentPacket;
use Nicholass003\Axiom\Packet\InventoryTransactionPacket;
use Nicholass003\Axiom\Packet\LevelSoundEventPacket;
use Nicholass003\Axiom\Packet\MobArmorEquipmentPacket;
use Nicholass003\Axiom\Packet\PartyDestinationCookieResponsePacket;
use Nicholass003\Axiom\Packet\SendPartyDestinationCookiePacket;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use Nicholass003\Axiom\Packet\ServerPresenceInfoPacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\SubChunkRequestPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol1001 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol975::buildCodecType()->fork();
        $codec->override(PresenceConfig::class, new PresenceConfigSerializer());
        $codec->override(LevelSettingsData::class, new LevelSettingsDataSerializer());
        $codec->override(TransactionData::class, new InventoryTransactionDataSerializer());
        $codec->override(NetworkInventoryAction::class, new NetworkInventoryActionSerializer());
        $codec->override(ReleaseItemTransactionData::class, new ReleaseItemTransactionDataSerializer());
        $codec->override(UseItemOnEntityTransactionData::class, new UseItemOnEntityTransactionDataSerializer());
        $codec->override(UseItemTransactionData::class, new UseItemTransactionDataSerializer());
        $codec->override(WhiskerScopeDataSummary::class, new WhiskerScopeDataSummarySerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol975::build()->fork(ProtocolVersion::v1001, $mc?->__toString() ?? "1.26.30")
            ->register(ClientboundUpdateSoundDataPacket::ID, new ClientboundUpdateSoundDataCodec())
            ->register(SendPartyDestinationCookiePacket::ID, new SendPartyDestinationCookieCodec())
            ->register(PartyDestinationCookieResponsePacket::ID, new PartyDestinationCookieResponseCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(InventoryTransactionPacket::ID, new InventoryTransactionCodec())
            ->override(MobArmorEquipmentPacket::ID, new MobArmorEquipmentCodec())
            ->override(InventoryContentPacket::ID, new InventoryContentCodec())
            ->override(BossEventPacket::ID, new BossEventCodec())
            ->override(LevelSoundEventPacket::ID, new LevelSoundEventCodec())
            ->override(SubChunkRequestPacket::ID, new SubChunkRequestCodec())
            ->override(ServerboundDiagnosticsPacket::ID, new ServerboundDiagnosticsCodec())
            ->override(GraphicsOverrideParameterPacket::ID, new GraphicsOverrideParameterCodec())
            ->override(ServerPresenceInfoPacket::ID, new ServerPresenceInfoCodec());
    }
}
