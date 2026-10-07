<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v2168\AddActorCodec;
use Nicholass003\Axiom\Codec\v2168\AnvilDamageCodec;
use Nicholass003\Axiom\Codec\v2168\ClientboundUpdateSoundDataCodec;
use Nicholass003\Axiom\Codec\v2168\GameRulesChangedCodec;
use Nicholass003\Axiom\Codec\v2168\InventoryContentCodec;
use Nicholass003\Axiom\Codec\v2168\InventorySlotCodec;
use Nicholass003\Axiom\Codec\v2168\InventoryTransactionCodec;
use Nicholass003\Axiom\Codec\v2168\LevelChunkCodec;
use Nicholass003\Axiom\Codec\v2168\MobArmorEquipmentCodec;
use Nicholass003\Axiom\Codec\v2168\MobEquipmentCodec;
use Nicholass003\Axiom\Codec\v2168\MoveActorDeltaCodec;
use Nicholass003\Axiom\Codec\v2168\MovePlayerCodec;
use Nicholass003\Axiom\Codec\v2168\PlayerAuthInputCodec;
use Nicholass003\Axiom\Codec\v2168\PlayerListCodec;
use Nicholass003\Axiom\Codec\v2168\PlayerLocationCodec;
use Nicholass003\Axiom\Codec\v2168\PlaySoundCodec;
use Nicholass003\Axiom\Codec\v2168\Serializer\AttributeSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\EntityDiagnosticTimingInfoSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\GatheringJoinInfoSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\InventoryTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\MismatchTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\NormalTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\ReleaseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\StackResponse\ItemStackResponseSlotInfoSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\UseItemOnEntityTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Inventory\UseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\ItemStackWrapperSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\MemoryCategoryCounterSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\MovePlayerTeleportDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\PlayerListEntrySerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Score\ScoreboardIdentityPacketEntrySerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Score\ScorePacketEntrySerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Skin\SkinDataSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Skin\SkinImageSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\Sound\SoundDataEventSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\SystemCategorySerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\SystemDiagnosticTimingInfoSerializer;
use Nicholass003\Axiom\Codec\v2168\Serializer\WhiskerScopeDataSummarySerializer;
use Nicholass003\Axiom\Codec\v2168\ServerboundDiagnosticsCodec;
use Nicholass003\Axiom\Codec\v2168\SetScoreboardIdentityCodec;
use Nicholass003\Axiom\Codec\v2168\SetScoreCodec;
use Nicholass003\Axiom\Codec\v2168\StartGameCodec;
use Nicholass003\Axiom\Codec\v2168\TransferCodec;use Nicholass003\Axiom\Data\Type\Attribute;
use Nicholass003\Axiom\Data\Type\EntityDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\GatheringJoinInfo;
use Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\MemoryCategoryCounter;
use Nicholass003\Axiom\Data\Type\MovePlayerTeleportData;
use Nicholass003\Axiom\Data\Type\PlayerListEntry;
use Nicholass003\Axiom\Data\Type\Score\ScoreboardIdentityPacketEntry;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Data\Type\Skin\SkinImage;
use Nicholass003\Axiom\Data\Type\Sound\SoundDataEvent;
use Nicholass003\Axiom\Data\Type\SystemCategory;
use Nicholass003\Axiom\Data\Type\SystemDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\WhiskerScopeDataSummary;
use Nicholass003\Axiom\Packet\AddActorPacket;
use Nicholass003\Axiom\Packet\AnvilDamagePacket;
use Nicholass003\Axiom\Packet\ClientboundUpdateSoundDataPacket;
use Nicholass003\Axiom\Packet\GameRulesChangedPacket;
use Nicholass003\Axiom\Packet\InventoryContentPacket;
use Nicholass003\Axiom\Packet\InventorySlotPacket;
use Nicholass003\Axiom\Packet\InventoryTransactionPacket;
use Nicholass003\Axiom\Packet\LevelChunkPacket;
use Nicholass003\Axiom\Packet\MobArmorEquipmentPacket;
use Nicholass003\Axiom\Packet\MobEquipmentPacket;
use Nicholass003\Axiom\Packet\MoveActorDeltaPacket;
use Nicholass003\Axiom\Packet\MovePlayerPacket;
use Nicholass003\Axiom\Packet\PlayerAuthInputPacket;
use Nicholass003\Axiom\Packet\PlayerListPacket;
use Nicholass003\Axiom\Packet\PlayerLocationPacket;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use Nicholass003\Axiom\Packet\SetScoreboardIdentityPacket;
use Nicholass003\Axiom\Packet\SetScorePacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\TransferPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol2168 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol1001::buildCodecType()->fork();
        $codec->register(Attribute::class, new AttributeSerializer());
        $codec->override(EntityDiagnosticTimingInfo::class, new EntityDiagnosticTimingInfoSerializer());
        $codec->override(GatheringJoinInfo::class, new GatheringJoinInfoSerializer());
        $codec->override(ItemStackWrapper::class, new ItemStackWrapperSerializer());
        $codec->override(MemoryCategoryCounter::class, new MemoryCategoryCounterSerializer());
        $codec->override(MovePlayerTeleportData::class, new MovePlayerTeleportDataSerializer());
        $codec->override(PlayerListEntry::class, new PlayerListEntrySerializer());
        $codec->override(SkinData::class, new SkinDataSerializer());
        $codec->override(SkinImage::class, new SkinImageSerializer());
        $codec->override(ScoreboardIdentityPacketEntry::class, new ScoreboardIdentityPacketEntrySerializer());
        $codec->override(ScorePacketEntry::class, new ScorePacketEntrySerializer());
        $codec->override(ItemStackResponseSlotInfo::class, new ItemStackResponseSlotInfoSerializer());
        $codec->override(SoundDataEvent::class, new SoundDataEventSerializer());
        $codec->override(SystemCategory::class, new SystemCategorySerializer());
        $codec->override(SystemDiagnosticTimingInfo::class, new SystemDiagnosticTimingInfoSerializer());
        $codec->override(WhiskerScopeDataSummary::class, new WhiskerScopeDataSummarySerializer());
        $codec->override(NormalTransactionData::class, new NormalTransactionDataSerializer());
        $codec->override(MismatchTransactionData::class, new MismatchTransactionDataSerializer());
        $codec->override(TransactionData::class, new InventoryTransactionDataSerializer());
        $codec->override(UseItemTransactionData::class, new UseItemTransactionDataSerializer());
        $codec->override(UseItemOnEntityTransactionData::class, new UseItemOnEntityTransactionDataSerializer());
        $codec->override(ReleaseItemTransactionData::class, new ReleaseItemTransactionDataSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        if($mc && $mc->isAtLeast("1.26.44")){
            return Protocol2168_h4::build($mc);
        }

        return Protocol1001::build($mc)->fork(ProtocolVersion::v2168, $mc?->__toString() ?? "1.26.40")
            ->overrideCodecType(self::buildCodecType())
            ->override(AddActorPacket::ID, new AddActorCodec())
            ->override(GameRulesChangedPacket::ID, new GameRulesChangedCodec())
            ->override(AnvilDamagePacket::ID, new AnvilDamageCodec())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(ClientboundUpdateSoundDataPacket::ID, new ClientboundUpdateSoundDataCodec())
            ->override(MoveActorDeltaPacket::ID, new MoveActorDeltaCodec())
            ->override(MovePlayerPacket::ID, new MovePlayerCodec())
            ->override(InventoryContentPacket::ID, new InventoryContentCodec())
            ->override(InventorySlotPacket::ID, new InventorySlotCodec())
            ->override(InventoryTransactionPacket::ID, new InventoryTransactionCodec())
            ->override(MobArmorEquipmentPacket::ID, new MobArmorEquipmentCodec())
            ->override(MobEquipmentPacket::ID, new MobEquipmentCodec())
            ->override(LevelChunkPacket::ID, new LevelChunkCodec())
            ->override(PlayerListPacket::ID, new PlayerListCodec())
            ->override(PlayerAuthInputPacket::ID, new PlayerAuthInputCodec())
            ->override(PlayerLocationPacket::ID, new PlayerLocationCodec())
            ->override(PlaySoundPacket::ID, new PlaySoundCodec())
            ->override(TransferPacket::ID, new TransferCodec())
            ->override(ServerboundDiagnosticsPacket::ID, new ServerboundDiagnosticsCodec())
            ->override(SetScoreboardIdentityPacket::ID, new SetScoreboardIdentityCodec())
            ->override(SetScorePacket::ID, new SetScoreCodec());
    }
}
