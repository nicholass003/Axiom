<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v844\ActorEventCodec;
use Nicholass003\Axiom\Codec\v844\ActorPickRequestCodec;
use Nicholass003\Axiom\Codec\v844\AddActorCodec;
use Nicholass003\Axiom\Codec\v844\AddBehaviorTreeCodec;
use Nicholass003\Axiom\Codec\v844\AddItemActorCodec;
use Nicholass003\Axiom\Codec\v844\AddPaintingCodec;
use Nicholass003\Axiom\Codec\v844\AddPlayerCodec;
use Nicholass003\Axiom\Codec\v844\AddVolumeEntityCodec;
use Nicholass003\Axiom\Codec\v844\AgentActionEventCodec;
use Nicholass003\Axiom\Codec\v844\AgentAnimationCodec;
use Nicholass003\Axiom\Codec\v844\AnimateCodec;
use Nicholass003\Axiom\Codec\v844\AnimateEntityCodec;
use Nicholass003\Axiom\Codec\v844\AnvilDamageCodec;
use Nicholass003\Axiom\Codec\v844\AutomationClientConnectCodec;
use Nicholass003\Axiom\Codec\v844\AvailableActorIdentifiersCodec;
use Nicholass003\Axiom\Codec\v844\AvailableCommandsCodec;
use Nicholass003\Axiom\Codec\v844\AwardAchievementCodec;
use Nicholass003\Axiom\Codec\v844\BiomeDefinitionListCodec;
use Nicholass003\Axiom\Codec\v844\BlockActorDataCodec;
use Nicholass003\Axiom\Codec\v844\BlockEventCodec;
use Nicholass003\Axiom\Codec\v844\BlockPickRequestCodec;
use Nicholass003\Axiom\Codec\v844\BookEditCodec;
use Nicholass003\Axiom\Codec\v844\BossEventCodec;
use Nicholass003\Axiom\Codec\v844\CameraAimAssistCodec;
use Nicholass003\Axiom\Codec\v844\CameraAimAssistPresetsCodec;
use Nicholass003\Axiom\Codec\v844\CameraCodec;
use Nicholass003\Axiom\Codec\v844\CameraInstructionCodec;
use Nicholass003\Axiom\Codec\v844\CameraPresetsCodec;
use Nicholass003\Axiom\Codec\v844\CameraShakeCodec;
use Nicholass003\Axiom\Codec\v844\ChangeDimensionCodec;
use Nicholass003\Axiom\Codec\v844\ChangeMobPropertyCodec;
use Nicholass003\Axiom\Codec\v844\ChunkRadiusUpdatedCodec;
use Nicholass003\Axiom\Codec\v844\ClientboundCloseFormCodec;
use Nicholass003\Axiom\Codec\v844\ClientboundControlSchemeSetCodec;
use Nicholass003\Axiom\Codec\v844\ClientboundDebugRendererCodec;
use Nicholass003\Axiom\Codec\v844\ClientboundMapItemDataCodec;
use Nicholass003\Axiom\Codec\v844\ClientCacheBlobStatusCodec;
use Nicholass003\Axiom\Codec\v844\ClientCacheMissResponseCodec;
use Nicholass003\Axiom\Codec\v844\ClientCacheStatusCodec;
use Nicholass003\Axiom\Codec\v844\ClientCameraAimAssistCodec;
use Nicholass003\Axiom\Codec\v844\ClientMovementPredictionSyncCodec;
use Nicholass003\Axiom\Codec\v844\ClientToServerHandshakeCodec;
use Nicholass003\Axiom\Codec\v844\CodeBuilderCodec;
use Nicholass003\Axiom\Codec\v844\CodeBuilderSourceCodec;
use Nicholass003\Axiom\Codec\v844\CommandBlockUpdateCodec;
use Nicholass003\Axiom\Codec\v844\CommandOutputCodec;
use Nicholass003\Axiom\Codec\v844\CommandRequestCodec;
use Nicholass003\Axiom\Codec\v844\CompletedUsingItemCodec;
use Nicholass003\Axiom\Codec\v844\ContainerCloseCodec;
use Nicholass003\Axiom\Codec\v844\ContainerOpenCodec;
use Nicholass003\Axiom\Codec\v844\ContainerRegistryCleanupCodec;
use Nicholass003\Axiom\Codec\v844\ContainerSetDataCodec;
use Nicholass003\Axiom\Codec\v844\CorrectPlayerMovePredictionCodec;
use Nicholass003\Axiom\Codec\v844\CraftingDataCodec;
use Nicholass003\Axiom\Codec\v844\CreatePhotoCodec;
use Nicholass003\Axiom\Codec\v844\CreativeContentCodec;
use Nicholass003\Axiom\Codec\v844\CurrentStructureFeatureCodec;
use Nicholass003\Axiom\Codec\v844\DeathInfoCodec;
use Nicholass003\Axiom\Codec\v844\DebugInfoCodec;
use Nicholass003\Axiom\Codec\v844\DimensionDataCodec;
use Nicholass003\Axiom\Codec\v844\DisconnectCodec;
use Nicholass003\Axiom\Codec\v844\EditorNetworkCodec;
use Nicholass003\Axiom\Codec\v844\EducationSettingsCodec;
use Nicholass003\Axiom\Codec\v844\EduUriResourceCodec;
use Nicholass003\Axiom\Codec\v844\EmoteCodec;
use Nicholass003\Axiom\Codec\v844\EmoteListCodec;
use Nicholass003\Axiom\Codec\v844\FeatureRegistryCodec;
use Nicholass003\Axiom\Codec\v844\GameRulesChangedCodec;
use Nicholass003\Axiom\Codec\v844\GameTestRequestCodec;
use Nicholass003\Axiom\Codec\v844\GameTestResultsCodec;
use Nicholass003\Axiom\Codec\v844\GuiDataPickItemCodec;
use Nicholass003\Axiom\Codec\v844\HurtArmorCodec;
use Nicholass003\Axiom\Codec\v844\InteractCodec;
use Nicholass003\Axiom\Codec\v844\InventoryContentCodec;
use Nicholass003\Axiom\Codec\v844\InventorySlotCodec;
use Nicholass003\Axiom\Codec\v844\InventoryTransactionCodec;
use Nicholass003\Axiom\Codec\v844\ItemRegistryCodec;
use Nicholass003\Axiom\Codec\v844\ItemStackRequestCodec;
use Nicholass003\Axiom\Codec\v844\ItemStackResponseCodec;
use Nicholass003\Axiom\Codec\v844\JigsawStructureDataCodec;
use Nicholass003\Axiom\Codec\v844\LabTableCodec;
use Nicholass003\Axiom\Codec\v844\LecternUpdateCodec;
use Nicholass003\Axiom\Codec\v844\LegacyTelemetryEventCodec;
use Nicholass003\Axiom\Codec\v844\LessonProgressCodec;
use Nicholass003\Axiom\Codec\v844\LevelChunkCodec;
use Nicholass003\Axiom\Codec\v844\LevelEventCodec;
use Nicholass003\Axiom\Codec\v844\LevelEventGenericCodec;
use Nicholass003\Axiom\Codec\v844\LevelSoundEventCodec;
use Nicholass003\Axiom\Codec\v844\LoginCodec;
use Nicholass003\Axiom\Codec\v844\MapCreateLockedCopyCodec;
use Nicholass003\Axiom\Codec\v844\MapInfoRequestCodec;
use Nicholass003\Axiom\Codec\v844\MobArmorEquipmentCodec;
use Nicholass003\Axiom\Codec\v844\MobEffectCodec;
use Nicholass003\Axiom\Codec\v844\MobEquipmentCodec;
use Nicholass003\Axiom\Codec\v844\ModalFormRequestCodec;
use Nicholass003\Axiom\Codec\v844\ModalFormResponseCodec;
use Nicholass003\Axiom\Codec\v844\MotionPredictionHintsCodec;
use Nicholass003\Axiom\Codec\v844\MoveActorAbsoluteCodec;
use Nicholass003\Axiom\Codec\v844\MoveActorDeltaCodec;
use Nicholass003\Axiom\Codec\v844\MovementEffectCodec;
use Nicholass003\Axiom\Codec\v844\MovePlayerCodec;
use Nicholass003\Axiom\Codec\v844\MultiplayerSettingsCodec;
use Nicholass003\Axiom\Codec\v844\NetworkChunkPublisherUpdateCodec;
use Nicholass003\Axiom\Codec\v844\NetworkSettingsCodec;
use Nicholass003\Axiom\Codec\v844\NetworkStackLatencyCodec;
use Nicholass003\Axiom\Codec\v844\NpcDialogueCodec;
use Nicholass003\Axiom\Codec\v844\NpcRequestCodec;
use Nicholass003\Axiom\Codec\v844\OnScreenTextureAnimationCodec;
use Nicholass003\Axiom\Codec\v844\OpenSignCodec;
use Nicholass003\Axiom\Codec\v844\PacketViolationWarningCodec;
use Nicholass003\Axiom\Codec\v844\PhotoTransferCodec;
use Nicholass003\Axiom\Codec\v844\PlayerActionCodec;
use Nicholass003\Axiom\Codec\v844\PlayerArmorDamageCodec;
use Nicholass003\Axiom\Codec\v844\PlayerAuthInputCodec;
use Nicholass003\Axiom\Codec\v844\PlayerEnchantOptionsCodec;
use Nicholass003\Axiom\Codec\v844\PlayerFogCodec;
use Nicholass003\Axiom\Codec\v844\PlayerHotbarCodec;
use Nicholass003\Axiom\Codec\v844\PlayerListCodec;
use Nicholass003\Axiom\Codec\v844\PlayerLocationCodec;
use Nicholass003\Axiom\Codec\v844\PlayerSkinCodec;
use Nicholass003\Axiom\Codec\v844\PlayerStartItemCooldownCodec;
use Nicholass003\Axiom\Codec\v844\PlayerToggleCrafterSlotRequestCodec;
use Nicholass003\Axiom\Codec\v844\PlayerUpdateEntityOverridesCodec;
use Nicholass003\Axiom\Codec\v844\PlayerVideoCaptureCodec;
use Nicholass003\Axiom\Codec\v844\PlaySoundCodec;
use Nicholass003\Axiom\Codec\v844\PlayStatusCodec;
use Nicholass003\Axiom\Codec\v844\PositionTrackingDBClientRequestCodec;
use Nicholass003\Axiom\Codec\v844\PositionTrackingDBServerBroadcastCodec;
use Nicholass003\Axiom\Codec\v844\PrimitiveShapesCodec;
use Nicholass003\Axiom\Codec\v844\PurchaseReceiptCodec;
use Nicholass003\Axiom\Codec\v844\RefreshEntitlementsCodec;
use Nicholass003\Axiom\Codec\v844\RemoveActorCodec;
use Nicholass003\Axiom\Codec\v844\RemoveObjectiveCodec;
use Nicholass003\Axiom\Codec\v844\RemoveVolumeEntityCodec;
use Nicholass003\Axiom\Codec\v844\RequestAbilityCodec;
use Nicholass003\Axiom\Codec\v844\RequestChunkRadiusCodec;
use Nicholass003\Axiom\Codec\v844\RequestNetworkSettingsCodec;
use Nicholass003\Axiom\Codec\v844\RequestPermissionsCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePackChunkDataCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePackChunkRequestCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePackClientResponseCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePackDataInfoCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePacksInfoCodec;
use Nicholass003\Axiom\Codec\v844\ResourcePackStackCodec;
use Nicholass003\Axiom\Codec\v844\RespawnCodec;
use Nicholass003\Axiom\Codec\v844\ScriptMessageCodec;
use Nicholass003\Axiom\Codec\v844\Serializer\AbilitiesLayerSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Armor\ArmorSlotAndDamagePairSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\AttributeModifierSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeCappedSurfaceDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeClimateDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeConditionalTransformationDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeConsolidatedFeatureDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeConsolidatedFeaturesDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeCoordinateDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeDefinitionChunkGenDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeDefinitionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeDefinitionEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeElementDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeLegacyWorldGenRulesDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeMesaSurfaceDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeMountainParamsDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeMultinoiseGenRulesDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeOverworldGenRulesDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeReplacementDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeScatterParamDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeSurfaceMaterialAdjustmentDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeSurfaceMaterialDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeWeightedDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Biome\BiomeWeightedTemperatureDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\BlockPaletteEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistCategoryBlockPrioritySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistCategoryEntityPrioritySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistCategorySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistPresetExclusionDefinitionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistPresetItemSettingsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraAimAssistPresetSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraFadeInstructionColorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraFadeInstructionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraFadeInstructionTimeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraFovInstructionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraPresetAimAssistSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraPresetSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraProgressOptionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraRotationOptionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraSetInstructionEaseSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraSetInstructionRotationSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraSetInstructionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraSplineDefinitionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraSplineInstructionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Camera\CameraTargetInstructionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ChunkCacheBlobSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\ChainedSubCommandDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\ChainedSubCommandValueSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandEnumConstraintSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandEnumSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandOriginDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandOutputMessageSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandOverloadSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandParameterSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Command\CommandSoftEnumSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Debug\DebugMarkerDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Debug\PacketShapeDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\DimensionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Education\EducationSettingsAgentCapabilitiesSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Education\EducationSettingsExternalLinkSettingsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Education\EducationUriResourceSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Enchant\EnchantOptionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Enchant\EnchantSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ExperimentsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\FeatureRegistryPacketEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\GameRules\BoolGameRuleSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\GameRules\FloatGameRuleSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\GameRules\IntGameRuleSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\CreativeGroupEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\CreativeItemEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\FullContainerNameSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\InventoryTransactionChangedSlotsHackSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\InventoryTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\ItemInteractionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\MismatchTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\NetworkInventoryActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\NormalTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\ReleaseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\BeaconPaymentStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CraftingConsumeInputStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CraftingCreateSpecificResultStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CraftRecipeAutoStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CraftRecipeOptionalStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CraftRecipeStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\CreativeCreateStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\DeprecatedCraftingNonImplementedStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\DeprecatedCraftingResultsStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\DestroyStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\DropStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\GrindstoneStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\ItemStackRequestSlotInfoSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\LabTableCombineStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\LoomStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\MineBlockStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\PlaceStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\SwapStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest\TakeStackRequestActionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackResponse\ItemStackResponseContainerInfoSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackResponse\ItemStackResponseSlotInfoSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\UseItemOnEntityTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Inventory\UseItemTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ItemStackSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ItemStackWrapperSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ItemTypeEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\LevelSettingsDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Map\MapDecorationSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Map\MapImageSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Map\MapInfoRequestPacketClientPixelSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Map\MapTrackedObjectSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\NetworkPermissionsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\PlayerMovementSettingsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\PropertySyncDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\ComplexAliasItemDescriptorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\FurnaceRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\IntIdMetaItemDescriptorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\MaterialReducerRecipeOutputSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\MaterialReducerRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\MolangItemDescriptorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\MultiRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\PotionContainerChangeRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\PotionTypeRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\RecipeIngredientSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\RecipeUnlockingRequirementSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\RecipeWithTypeIdSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\ShapedRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\ShapelessRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\SmithingTransformRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\SmithingTrimRecipeSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\StringIdMetaItemDescriptorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Recipe\TagItemDescriptorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ResourcePack\ResourcePackInfoEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\ResourcePack\ResourcePackStackEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Scoreboard\ScoreboardIdentityPacketEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Scoreboard\ScorePacketEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Skin\PersonaPieceTintColorSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Skin\PersonaSkinPieceSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Skin\SkinAnimationSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Skin\SkinDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Skin\SkinImageSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Structure\StructureEditorDataSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Structure\StructureSettingsSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\SubChunk\SubChunkPacketEntryCommonSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\SubChunk\SubChunkPacketHeightMapInfoSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\SubChunk\SubChunkPositionOffsetSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\SubChunk\SubChunkPositionSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\SubChunk\UpdateSubChunkBlocksPacketEntrySerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Trim\TrimMaterialSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\Trim\TrimPatternSerializer;
use Nicholass003\Axiom\Codec\v844\Serializer\UpdateAttributeSerializer;
use Nicholass003\Axiom\Codec\v844\ServerboundDiagnosticsCodec;
use Nicholass003\Axiom\Codec\v844\ServerboundLoadingScreenCodec;
use Nicholass003\Axiom\Codec\v844\ServerboundPackSettingChangeCodec;
use Nicholass003\Axiom\Codec\v844\ServerPlayerPostMovePositionCodec;
use Nicholass003\Axiom\Codec\v844\ServerSettingsRequestCodec;
use Nicholass003\Axiom\Codec\v844\ServerSettingsResponseCodec;
use Nicholass003\Axiom\Codec\v844\ServerStatsCodec;
use Nicholass003\Axiom\Codec\v844\ServerToClientHandshakeCodec;
use Nicholass003\Axiom\Codec\v844\SetActorDataCodec;
use Nicholass003\Axiom\Codec\v844\SetActorLinkCodec;
use Nicholass003\Axiom\Codec\v844\SetActorMotionCodec;
use Nicholass003\Axiom\Codec\v844\SetCommandsEnabledCodec;
use Nicholass003\Axiom\Codec\v844\SetDefaultGameTypeCodec;
use Nicholass003\Axiom\Codec\v844\SetDifficultyCodec;
use Nicholass003\Axiom\Codec\v844\SetDisplayObjectiveCodec;
use Nicholass003\Axiom\Codec\v844\SetHealthCodec;
use Nicholass003\Axiom\Codec\v844\SetHudCodec;
use Nicholass003\Axiom\Codec\v844\SetLastHurtByCodec;
use Nicholass003\Axiom\Codec\v844\SetLocalPlayerAsInitializedCodec;
use Nicholass003\Axiom\Codec\v844\SetPlayerGameTypeCodec;
use Nicholass003\Axiom\Codec\v844\SetPlayerInventoryOptionsCodec;
use Nicholass003\Axiom\Codec\v844\SetScoreboardIdentityCodec;
use Nicholass003\Axiom\Codec\v844\SetScoreCodec;
use Nicholass003\Axiom\Codec\v844\SetSpawnPositionCodec;
use Nicholass003\Axiom\Codec\v844\SetTimeCodec;
use Nicholass003\Axiom\Codec\v844\SettingsCommandCodec;
use Nicholass003\Axiom\Codec\v844\SetTitleCodec;
use Nicholass003\Axiom\Codec\v844\ShowCreditsCodec;
use Nicholass003\Axiom\Codec\v844\ShowProfileCodec;
use Nicholass003\Axiom\Codec\v844\ShowStoreOfferCodec;
use Nicholass003\Axiom\Codec\v844\SimpleEventCodec;
use Nicholass003\Axiom\Codec\v844\SimulationTypeCodec;
use Nicholass003\Axiom\Codec\v844\SpawnExperienceOrbCodec;
use Nicholass003\Axiom\Codec\v844\SpawnParticleEffectCodec;
use Nicholass003\Axiom\Codec\v844\StartGameCodec;
use Nicholass003\Axiom\Codec\v844\StopSoundCodec;
use Nicholass003\Axiom\Codec\v844\StructureBlockUpdateCodec;
use Nicholass003\Axiom\Codec\v844\StructureTemplateDataRequestCodec;
use Nicholass003\Axiom\Codec\v844\StructureTemplateDataResponseCodec;
use Nicholass003\Axiom\Codec\v844\SubChunkCodec;
use Nicholass003\Axiom\Codec\v844\SubChunkRequestCodec;
use Nicholass003\Axiom\Codec\v844\SubClientLoginCodec;
use Nicholass003\Axiom\Codec\v844\SyncActorPropertyCodec;
use Nicholass003\Axiom\Codec\v844\TakeItemActorCodec;
use Nicholass003\Axiom\Codec\v844\TextCodec;
use Nicholass003\Axiom\Codec\v844\TickingAreasLoadStatusCodec;
use Nicholass003\Axiom\Codec\v844\ToastRequestCodec;
use Nicholass003\Axiom\Codec\v844\TransferCodec;
use Nicholass003\Axiom\Codec\v844\TrimDataCodec;
use Nicholass003\Axiom\Codec\v844\UnlockedRecipesCodec;
use Nicholass003\Axiom\Codec\v844\UpdateAbilitiesCodec;
use Nicholass003\Axiom\Codec\v844\UpdateAdventureSettingsCodec;
use Nicholass003\Axiom\Codec\v844\UpdateAttributesCodec;
use Nicholass003\Axiom\Codec\v844\UpdateBlockCodec;
use Nicholass003\Axiom\Codec\v844\UpdateBlockSyncedCodec;
use Nicholass003\Axiom\Codec\v844\UpdateClientInputLocksCodec;
use Nicholass003\Axiom\Codec\v844\UpdateClientOptionsCodec;
use Nicholass003\Axiom\Codec\v844\UpdateEquipCodec;
use Nicholass003\Axiom\Codec\v844\UpdatePlayerGameTypeCodec;
use Nicholass003\Axiom\Codec\v844\UpdateSoftEnumCodec;
use Nicholass003\Axiom\Codec\v844\UpdateSubChunkBlocksCodec;
use Nicholass003\Axiom\Codec\v844\UpdateTradeCodec;
use Nicholass003\Axiom\Data\Type\AbilitiesLayer;
use Nicholass003\Axiom\Data\Type\Armor\ArmorSlotAndDamagePair;
use Nicholass003\Axiom\Data\Type\AttributeModifier;
use Nicholass003\Axiom\Data\Type\Biome\BiomeDefinitionData;
use Nicholass003\Axiom\Data\Type\Biome\BiomeDefinitionEntry;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCappedSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeClimateData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConditionalTransformationData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeatureData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeConsolidatedFeaturesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCoordinateData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeElementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeLegacyWorldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMesaSurfaceData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMountainParamsData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMultinoiseGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeOverworldGenRulesData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeScatterParamData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialAdjustmentData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeWeightedTemperatureData;
use Nicholass003\Axiom\Data\Type\BlockPaletteEntry;
use Nicholass003\Axiom\Data\Type\BoolGameRule;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryBlockPriority;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryEntityPriority;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPreset;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetExclusionDefinition;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetItemSettings;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionColor;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionTime;
use Nicholass003\Axiom\Data\Type\Camera\CameraFovInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraPreset;
use Nicholass003\Axiom\Data\Type\Camera\CameraPresetAimAssist;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstructionEase;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstructionRotation;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineDefinition;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraTargetInstruction;
use Nicholass003\Axiom\Data\Type\ChunkCacheBlob;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandRawData;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandValueRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumConstraintRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Data\Type\Command\CommandOutputMessage;
use Nicholass003\Axiom\Data\Type\Command\CommandOverloadRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandParameterRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandSoftEnum;
use Nicholass003\Axiom\Data\Type\Debug\DebugMarkerData;
use Nicholass003\Axiom\Data\Type\Debug\PacketShapeData;
use Nicholass003\Axiom\Data\Type\DimensionData;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsAgentCapabilities;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsExternalLinkSettings;
use Nicholass003\Axiom\Data\Type\Education\EducationUriResource;
use Nicholass003\Axiom\Data\Type\Enchant\Enchant;
use Nicholass003\Axiom\Data\Type\Enchant\EnchantOption;
use Nicholass003\Axiom\Data\Type\Entity\UpdateAttribute;
use Nicholass003\Axiom\Data\Type\Experiments;
use Nicholass003\Axiom\Data\Type\FeatureRegistryPacketEntry;
use Nicholass003\Axiom\Data\Type\FloatGameRule;
use Nicholass003\Axiom\Data\Type\IntGameRule;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeGroupEntry;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeItemEntry;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\Inventory\InventoryTransactionChangedSlotsHack;
use Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction;
use Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\BeaconPaymentStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftingConsumeInputStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftingCreateSpecificResultStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeAutoStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeOptionalStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CreativeCreateStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingNonImplementedStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingResultsStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DestroyStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DropStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\GrindstoneStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequestSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\LabTableCombineStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\LoomStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\MineBlockStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\PlaceStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\SwapStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\TakeStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseContainerInfo;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Data\Type\ItemInteractionData;
use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\ItemTypeEntry;
use Nicholass003\Axiom\Data\Type\LevelSettingsData;
use Nicholass003\Axiom\Data\Type\Map\MapDecoration;
use Nicholass003\Axiom\Data\Type\Map\MapImage;
use Nicholass003\Axiom\Data\Type\Map\MapInfoRequestPacketClientPixel;
use Nicholass003\Axiom\Data\Type\Map\MapTrackedObject;
use Nicholass003\Axiom\Data\Type\NetworkPermissionsData;
use Nicholass003\Axiom\Data\Type\PlayerMovementSettingsData;
use Nicholass003\Axiom\Data\Type\PropertySyncData;
use Nicholass003\Axiom\Data\Type\Recipe\ComplexAliasItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\FurnaceRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\IntIdMetaItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipeOutput;
use Nicholass003\Axiom\Data\Type\Recipe\MolangItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\MultiRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionContainerChangeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionTypeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeUnlockingRequirement;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Data\Type\Recipe\ShapedRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\ShapelessRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTransformRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTrimRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\StringIdMetaItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\TagItemDescriptor;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackInfoEntry;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackStackEntry;
use Nicholass003\Axiom\Data\Type\Score\ScoreboardIdentityPacketEntry;
use Nicholass003\Axiom\Data\Type\Score\ScorePacketEntry;
use Nicholass003\Axiom\Data\Type\Skin\PersonaPieceTintColor;
use Nicholass003\Axiom\Data\Type\Skin\PersonaSkinPiece;
use Nicholass003\Axiom\Data\Type\Skin\SkinAnimation;
use Nicholass003\Axiom\Data\Type\Skin\SkinData;
use Nicholass003\Axiom\Data\Type\Skin\SkinImage;
use Nicholass003\Axiom\Data\Type\Structure\StructureEditorData;
use Nicholass003\Axiom\Data\Type\Structure\StructureSettings;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketEntryCommon;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketHeightMapInfo;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPosition;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPositionOffset;
use Nicholass003\Axiom\Data\Type\SubChunk\UpdateSubChunkBlocksPacketEntry;
use Nicholass003\Axiom\Data\Type\Trim\TrimMaterial;
use Nicholass003\Axiom\Data\Type\Trim\TrimPattern;
use Nicholass003\Axiom\Packet\ActorEventPacket;
use Nicholass003\Axiom\Packet\ActorPickRequestPacket;
use Nicholass003\Axiom\Packet\AddActorPacket;
use Nicholass003\Axiom\Packet\AddBehaviorTreePacket;
use Nicholass003\Axiom\Packet\AddItemActorPacket;
use Nicholass003\Axiom\Packet\AddPaintingPacket;
use Nicholass003\Axiom\Packet\AddPlayerPacket;
use Nicholass003\Axiom\Packet\AddVolumeEntityPacket;
use Nicholass003\Axiom\Packet\AgentActionEventPacket;
use Nicholass003\Axiom\Packet\AgentAnimationPacket;
use Nicholass003\Axiom\Packet\AnimateEntityPacket;
use Nicholass003\Axiom\Packet\AnimatePacket;
use Nicholass003\Axiom\Packet\AnvilDamagePacket;
use Nicholass003\Axiom\Packet\AutomationClientConnectPacket;
use Nicholass003\Axiom\Packet\AvailableActorIdentifiersPacket;
use Nicholass003\Axiom\Packet\AvailableCommandsPacket;
use Nicholass003\Axiom\Packet\AwardAchievementPacket;
use Nicholass003\Axiom\Packet\BiomeDefinitionListPacket;
use Nicholass003\Axiom\Packet\BlockActorDataPacket;
use Nicholass003\Axiom\Packet\BlockEventPacket;
use Nicholass003\Axiom\Packet\BlockPickRequestPacket;
use Nicholass003\Axiom\Packet\BookEditPacket;
use Nicholass003\Axiom\Packet\BossEventPacket;
use Nicholass003\Axiom\Packet\CameraAimAssistPacket;
use Nicholass003\Axiom\Packet\CameraAimAssistPresetsPacket;
use Nicholass003\Axiom\Packet\CameraInstructionPacket;
use Nicholass003\Axiom\Packet\CameraPacket;
use Nicholass003\Axiom\Packet\CameraPresetsPacket;
use Nicholass003\Axiom\Packet\CameraShakePacket;
use Nicholass003\Axiom\Packet\ChangeDimensionPacket;
use Nicholass003\Axiom\Packet\ChangeMobPropertyPacket;
use Nicholass003\Axiom\Packet\ChunkRadiusUpdatedPacket;
use Nicholass003\Axiom\Packet\ClientboundCloseFormPacket;
use Nicholass003\Axiom\Packet\ClientboundControlSchemeSetPacket;
use Nicholass003\Axiom\Packet\ClientboundDebugRendererPacket;
use Nicholass003\Axiom\Packet\ClientboundMapItemDataPacket;
use Nicholass003\Axiom\Packet\ClientCacheBlobStatusPacket;
use Nicholass003\Axiom\Packet\ClientCacheMissResponsePacket;
use Nicholass003\Axiom\Packet\ClientCacheStatusPacket;
use Nicholass003\Axiom\Packet\ClientCameraAimAssistPacket;
use Nicholass003\Axiom\Packet\ClientMovementPredictionSyncPacket;
use Nicholass003\Axiom\Packet\ClientToServerHandshakePacket;
use Nicholass003\Axiom\Packet\CodeBuilderPacket;
use Nicholass003\Axiom\Packet\CodeBuilderSourcePacket;
use Nicholass003\Axiom\Packet\CommandBlockUpdatePacket;
use Nicholass003\Axiom\Packet\CommandOutputPacket;
use Nicholass003\Axiom\Packet\CommandRequestPacket;
use Nicholass003\Axiom\Packet\CompletedUsingItemPacket;
use Nicholass003\Axiom\Packet\ContainerClosePacket;
use Nicholass003\Axiom\Packet\ContainerOpenPacket;
use Nicholass003\Axiom\Packet\ContainerRegistryCleanupPacket;
use Nicholass003\Axiom\Packet\ContainerSetDataPacket;
use Nicholass003\Axiom\Packet\CorrectPlayerMovePredictionPacket;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use Nicholass003\Axiom\Packet\CreatePhotoPacket;
use Nicholass003\Axiom\Packet\CreativeContentPacket;
use Nicholass003\Axiom\Packet\CurrentStructureFeaturePacket;
use Nicholass003\Axiom\Packet\DeathInfoPacket;
use Nicholass003\Axiom\Packet\DebugInfoPacket;
use Nicholass003\Axiom\Packet\DimensionDataPacket;
use Nicholass003\Axiom\Packet\DisconnectPacket;
use Nicholass003\Axiom\Packet\EditorNetworkPacket;
use Nicholass003\Axiom\Packet\EducationSettingsPacket;
use Nicholass003\Axiom\Packet\EduUriResourcePacket;
use Nicholass003\Axiom\Packet\EmoteListPacket;
use Nicholass003\Axiom\Packet\EmotePacket;
use Nicholass003\Axiom\Packet\FeatureRegistryPacket;
use Nicholass003\Axiom\Packet\GameRulesChangedPacket;
use Nicholass003\Axiom\Packet\GameTestRequestPacket;
use Nicholass003\Axiom\Packet\GameTestResultsPacket;
use Nicholass003\Axiom\Packet\GuiDataPickItemPacket;
use Nicholass003\Axiom\Packet\HurtArmorPacket;
use Nicholass003\Axiom\Packet\InteractPacket;
use Nicholass003\Axiom\Packet\InventoryContentPacket;
use Nicholass003\Axiom\Packet\InventorySlotPacket;
use Nicholass003\Axiom\Packet\InventoryTransactionPacket;
use Nicholass003\Axiom\Packet\ItemRegistryPacket;
use Nicholass003\Axiom\Packet\ItemStackRequestPacket;
use Nicholass003\Axiom\Packet\ItemStackResponsePacket;
use Nicholass003\Axiom\Packet\JigsawStructureDataPacket;
use Nicholass003\Axiom\Packet\LabTablePacket;
use Nicholass003\Axiom\Packet\LecternUpdatePacket;
use Nicholass003\Axiom\Packet\LegacyTelemetryEventPacket;
use Nicholass003\Axiom\Packet\LessonProgressPacket;
use Nicholass003\Axiom\Packet\LevelChunkPacket;
use Nicholass003\Axiom\Packet\LevelEventGenericPacket;
use Nicholass003\Axiom\Packet\LevelEventPacket;
use Nicholass003\Axiom\Packet\LevelSoundEventPacket;
use Nicholass003\Axiom\Packet\LoginPacket;
use Nicholass003\Axiom\Packet\MapCreateLockedCopyPacket;
use Nicholass003\Axiom\Packet\MapInfoRequestPacket;
use Nicholass003\Axiom\Packet\MobArmorEquipmentPacket;
use Nicholass003\Axiom\Packet\MobEffectPacket;
use Nicholass003\Axiom\Packet\MobEquipmentPacket;
use Nicholass003\Axiom\Packet\ModalFormRequestPacket;
use Nicholass003\Axiom\Packet\ModalFormResponsePacket;
use Nicholass003\Axiom\Packet\MotionPredictionHintsPacket;
use Nicholass003\Axiom\Packet\MoveActorAbsolutePacket;
use Nicholass003\Axiom\Packet\MoveActorDeltaPacket;
use Nicholass003\Axiom\Packet\MovementEffectPacket;
use Nicholass003\Axiom\Packet\MovePlayerPacket;
use Nicholass003\Axiom\Packet\MultiplayerSettingsPacket;
use Nicholass003\Axiom\Packet\NetworkChunkPublisherUpdatePacket;
use Nicholass003\Axiom\Packet\NetworkSettingsPacket;
use Nicholass003\Axiom\Packet\NetworkStackLatencyPacket;
use Nicholass003\Axiom\Packet\NpcDialoguePacket;
use Nicholass003\Axiom\Packet\NpcRequestPacket;
use Nicholass003\Axiom\Packet\OnScreenTextureAnimationPacket;
use Nicholass003\Axiom\Packet\OpenSignPacket;
use Nicholass003\Axiom\Packet\PacketViolationWarningPacket;
use Nicholass003\Axiom\Packet\PhotoTransferPacket;
use Nicholass003\Axiom\Packet\PlayerActionPacket;
use Nicholass003\Axiom\Packet\PlayerArmorDamagePacket;
use Nicholass003\Axiom\Packet\PlayerAuthInputPacket;
use Nicholass003\Axiom\Packet\PlayerEnchantOptionsPacket;
use Nicholass003\Axiom\Packet\PlayerFogPacket;
use Nicholass003\Axiom\Packet\PlayerHotbarPacket;
use Nicholass003\Axiom\Packet\PlayerListPacket;
use Nicholass003\Axiom\Packet\PlayerLocationPacket;
use Nicholass003\Axiom\Packet\PlayerSkinPacket;
use Nicholass003\Axiom\Packet\PlayerStartItemCooldownPacket;
use Nicholass003\Axiom\Packet\PlayerToggleCrafterSlotRequestPacket;
use Nicholass003\Axiom\Packet\PlayerUpdateEntityOverridesPacket;
use Nicholass003\Axiom\Packet\PlayerVideoCapturePacket;
use Nicholass003\Axiom\Packet\PlaySoundPacket;
use Nicholass003\Axiom\Packet\PlayStatusPacket;
use Nicholass003\Axiom\Packet\PositionTrackingDBClientRequestPacket;
use Nicholass003\Axiom\Packet\PositionTrackingDBServerBroadcastPacket;
use Nicholass003\Axiom\Packet\PrimitiveShapesPacket;
use Nicholass003\Axiom\Packet\PurchaseReceiptPacket;
use Nicholass003\Axiom\Packet\RefreshEntitlementsPacket;
use Nicholass003\Axiom\Packet\RemoveActorPacket;
use Nicholass003\Axiom\Packet\RemoveObjectivePacket;
use Nicholass003\Axiom\Packet\RemoveVolumeEntityPacket;
use Nicholass003\Axiom\Packet\RequestAbilityPacket;
use Nicholass003\Axiom\Packet\RequestChunkRadiusPacket;
use Nicholass003\Axiom\Packet\RequestNetworkSettingsPacket;
use Nicholass003\Axiom\Packet\RequestPermissionsPacket;
use Nicholass003\Axiom\Packet\ResourcePackChunkDataPacket;
use Nicholass003\Axiom\Packet\ResourcePackChunkRequestPacket;
use Nicholass003\Axiom\Packet\ResourcePackClientResponsePacket;
use Nicholass003\Axiom\Packet\ResourcePackDataInfoPacket;
use Nicholass003\Axiom\Packet\ResourcePacksInfoPacket;
use Nicholass003\Axiom\Packet\ResourcePackStackPacket;
use Nicholass003\Axiom\Packet\RespawnPacket;
use Nicholass003\Axiom\Packet\ScriptMessagePacket;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use Nicholass003\Axiom\Packet\ServerboundLoadingScreenPacket;
use Nicholass003\Axiom\Packet\ServerboundPackSettingChangePacket;
use Nicholass003\Axiom\Packet\ServerPlayerPostMovePositionPacket;
use Nicholass003\Axiom\Packet\ServerSettingsRequestPacket;
use Nicholass003\Axiom\Packet\ServerSettingsResponsePacket;
use Nicholass003\Axiom\Packet\ServerStatsPacket;
use Nicholass003\Axiom\Packet\ServerToClientHandshakePacket;
use Nicholass003\Axiom\Packet\SetActorDataPacket;
use Nicholass003\Axiom\Packet\SetActorLinkPacket;
use Nicholass003\Axiom\Packet\SetActorMotionPacket;
use Nicholass003\Axiom\Packet\SetCommandsEnabledPacket;
use Nicholass003\Axiom\Packet\SetDefaultGameTypePacket;
use Nicholass003\Axiom\Packet\SetDifficultyPacket;
use Nicholass003\Axiom\Packet\SetDisplayObjectivePacket;
use Nicholass003\Axiom\Packet\SetHealthPacket;
use Nicholass003\Axiom\Packet\SetHudPacket;
use Nicholass003\Axiom\Packet\SetLastHurtByPacket;
use Nicholass003\Axiom\Packet\SetLocalPlayerAsInitializedPacket;
use Nicholass003\Axiom\Packet\SetPlayerGameTypePacket;
use Nicholass003\Axiom\Packet\SetPlayerInventoryOptionsPacket;
use Nicholass003\Axiom\Packet\SetScoreboardIdentityPacket;
use Nicholass003\Axiom\Packet\SetScorePacket;
use Nicholass003\Axiom\Packet\SetSpawnPositionPacket;
use Nicholass003\Axiom\Packet\SetTimePacket;
use Nicholass003\Axiom\Packet\SettingsCommandPacket;
use Nicholass003\Axiom\Packet\SetTitlePacket;
use Nicholass003\Axiom\Packet\ShowCreditsPacket;
use Nicholass003\Axiom\Packet\ShowProfilePacket;
use Nicholass003\Axiom\Packet\ShowStoreOfferPacket;
use Nicholass003\Axiom\Packet\SimpleEventPacket;
use Nicholass003\Axiom\Packet\SimulationTypePacket;
use Nicholass003\Axiom\Packet\SpawnExperienceOrbPacket;
use Nicholass003\Axiom\Packet\SpawnParticleEffectPacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\StopSoundPacket;
use Nicholass003\Axiom\Packet\StructureBlockUpdatePacket;
use Nicholass003\Axiom\Packet\StructureTemplateDataRequestPacket;
use Nicholass003\Axiom\Packet\StructureTemplateDataResponsePacket;
use Nicholass003\Axiom\Packet\SubChunkPacket;
use Nicholass003\Axiom\Packet\SubChunkRequestPacket;
use Nicholass003\Axiom\Packet\SubClientLoginPacket;
use Nicholass003\Axiom\Packet\SyncActorPropertyPacket;
use Nicholass003\Axiom\Packet\TakeItemActorPacket;
use Nicholass003\Axiom\Packet\TextPacket;
use Nicholass003\Axiom\Packet\TickingAreasLoadStatusPacket;
use Nicholass003\Axiom\Packet\ToastRequestPacket;
use Nicholass003\Axiom\Packet\TransferPacket;
use Nicholass003\Axiom\Packet\TrimDataPacket;
use Nicholass003\Axiom\Packet\UnlockedRecipesPacket;
use Nicholass003\Axiom\Packet\UpdateAbilitiesPacket;
use Nicholass003\Axiom\Packet\UpdateAdventureSettingsPacket;
use Nicholass003\Axiom\Packet\UpdateAttributesPacket;
use Nicholass003\Axiom\Packet\UpdateBlockPacket;
use Nicholass003\Axiom\Packet\UpdateBlockSyncedPacket;
use Nicholass003\Axiom\Packet\UpdateClientInputLocksPacket;
use Nicholass003\Axiom\Packet\UpdateClientOptionsPacket;
use Nicholass003\Axiom\Packet\UpdateEquipPacket;
use Nicholass003\Axiom\Packet\UpdatePlayerGameTypePacket;
use Nicholass003\Axiom\Packet\UpdateSoftEnumPacket;
use Nicholass003\Axiom\Packet\UpdateSubChunkBlocksPacket;
use Nicholass003\Axiom\Packet\UpdateTradePacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol844 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = new CodecType();
        $codec->register(AbilitiesLayer::class, new AbilitiesLayerSerializer());
        $codec->register(ArmorSlotAndDamagePair::class, new ArmorSlotAndDamagePairSerializer());
        $codec->register(AttributeModifier::class, new AttributeModifierSerializer());
        $codec->register(BeaconPaymentStackRequestAction::class, new BeaconPaymentStackRequestActionSerializer());
        $codec->register(BiomeCappedSurfaceData::class, new BiomeCappedSurfaceDataSerializer());
        $codec->register(BiomeClimateData::class, new BiomeClimateDataSerializer());
        $codec->register(BiomeConditionalTransformationData::class, new BiomeConditionalTransformationDataSerializer());
        $codec->register(BiomeConsolidatedFeatureData::class, new BiomeConsolidatedFeatureDataSerializer());
        $codec->register(BiomeConsolidatedFeaturesData::class, new BiomeConsolidatedFeaturesDataSerializer());
        $codec->register(BiomeCoordinateData::class, new BiomeCoordinateDataSerializer());
        $codec->register(BiomeDefinitionChunkGenData::class, new BiomeDefinitionChunkGenDataSerializer());
        $codec->register(BiomeDefinitionData::class, new BiomeDefinitionDataSerializer());
        $codec->register(BiomeDefinitionEntry::class, new BiomeDefinitionEntrySerializer());
        $codec->register(BiomeElementData::class, new BiomeElementDataSerializer());
        $codec->register(BiomeLegacyWorldGenRulesData::class, new BiomeLegacyWorldGenRulesDataSerializer());
        $codec->register(BiomeMesaSurfaceData::class, new BiomeMesaSurfaceDataSerializer());
        $codec->register(BiomeMountainParamsData::class, new BiomeMountainParamsDataSerializer());
        $codec->register(BiomeMultinoiseGenRulesData::class, new BiomeMultinoiseGenRulesDataSerializer());
        $codec->register(BiomeOverworldGenRulesData::class, new BiomeOverworldGenRulesDataSerializer());
        $codec->register(BiomeReplacementData::class, new BiomeReplacementDataSerializer());
        $codec->register(BiomeScatterParamData::class, new BiomeScatterParamDataSerializer());
        $codec->register(BiomeSurfaceMaterialAdjustmentData::class, new BiomeSurfaceMaterialAdjustmentDataSerializer());
        $codec->register(BiomeSurfaceMaterialData::class, new BiomeSurfaceMaterialDataSerializer());
        $codec->register(BiomeWeightedData::class, new BiomeWeightedDataSerializer());
        $codec->register(BiomeWeightedTemperatureData::class, new BiomeWeightedTemperatureDataSerializer());
        $codec->register(BlockPaletteEntry::class, new BlockPaletteEntrySerializer());
        $codec->register(BoolGameRule::class, new BoolGameRuleSerializer());
        $codec->register(CameraAimAssistCategory::class, new CameraAimAssistCategorySerializer());
        $codec->register(CameraAimAssistCategoryBlockPriority::class, new CameraAimAssistCategoryBlockPrioritySerializer());
        $codec->register(CameraAimAssistCategoryEntityPriority::class, new CameraAimAssistCategoryEntityPrioritySerializer());
        $codec->register(CameraAimAssistPreset::class, new CameraAimAssistPresetSerializer());
        $codec->register(CameraAimAssistPresetExclusionDefinition::class, new CameraAimAssistPresetExclusionDefinitionSerializer());
        $codec->register(CameraAimAssistPresetItemSettings::class, new CameraAimAssistPresetItemSettingsSerializer());
        $codec->register(CameraFadeInstruction::class, new CameraFadeInstructionSerializer());
        $codec->register(CameraFadeInstructionColor::class, new CameraFadeInstructionColorSerializer());
        $codec->register(CameraFadeInstructionTime::class, new CameraFadeInstructionTimeSerializer());
        $codec->register(CameraFovInstruction::class, new CameraFovInstructionSerializer());
        $codec->register(CameraPreset::class, new CameraPresetSerializer());
        $codec->register(CameraPresetAimAssist::class, new CameraPresetAimAssistSerializer());
        $codec->register(CameraProgressOption::class, new CameraProgressOptionSerializer());
        $codec->register(CameraRotationOption::class, new CameraRotationOptionSerializer());
        $codec->register(CameraSetInstruction::class, new CameraSetInstructionSerializer());
        $codec->register(CameraSetInstructionEase::class, new CameraSetInstructionEaseSerializer());
        $codec->register(CameraSetInstructionRotation::class, new CameraSetInstructionRotationSerializer());
        $codec->register(CameraSplineDefinition::class, new CameraSplineDefinitionSerializer());
        $codec->register(CameraSplineInstruction::class, new CameraSplineInstructionSerializer());
        $codec->register(CameraTargetInstruction::class, new CameraTargetInstructionSerializer());
        $codec->register(ChainedSubCommandRawData::class, new ChainedSubCommandDataSerializer());
        $codec->register(ChainedSubCommandValueRawData::class, new ChainedSubCommandValueSerializer());
        $codec->register(ChunkCacheBlob::class, new ChunkCacheBlobSerializer());
        $codec->register(CommandEnumConstraintRawData::class, new CommandEnumConstraintSerializer());
        $codec->register(CommandEnumRawData::class, new CommandEnumSerializer());
        $codec->register(CommandOriginData::class, new CommandOriginDataSerializer());
        $codec->register(CommandOutputMessage::class, new CommandOutputMessageSerializer());
        $codec->register(CommandOverloadRawData::class, new CommandOverloadSerializer());
        $codec->register(CommandParameterRawData::class, new CommandParameterSerializer());
        $codec->register(CommandRawData::class, new CommandDataSerializer());
        $codec->register(CommandSoftEnum::class, new CommandSoftEnumSerializer());
        $codec->register(ComplexAliasItemDescriptor::class, new ComplexAliasItemDescriptorSerializer());
        $codec->register(CraftRecipeAutoStackRequestAction::class, new CraftRecipeAutoStackRequestActionSerializer());
        $codec->register(CraftRecipeOptionalStackRequestAction::class, new CraftRecipeOptionalStackRequestActionSerializer());
        $codec->register(CraftRecipeStackRequestAction::class, new CraftRecipeStackRequestActionSerializer());
        $codec->register(CraftingConsumeInputStackRequestAction::class, new CraftingConsumeInputStackRequestActionSerializer());
        $codec->register(CraftingCreateSpecificResultStackRequestAction::class, new CraftingCreateSpecificResultStackRequestActionSerializer());
        $codec->register(CreativeCreateStackRequestAction::class, new CreativeCreateStackRequestActionSerializer());
        $codec->register(CreativeGroupEntry::class, new CreativeGroupEntrySerializer());
        $codec->register(CreativeItemEntry::class, new CreativeItemEntrySerializer());
        $codec->register(DebugMarkerData::class, new DebugMarkerDataSerializer());
        $codec->register(DeprecatedCraftingNonImplementedStackRequestAction::class, new DeprecatedCraftingNonImplementedStackRequestActionSerializer());
        $codec->register(DeprecatedCraftingResultsStackRequestAction::class, new DeprecatedCraftingResultsStackRequestActionSerializer());
        $codec->register(DestroyStackRequestAction::class, new DestroyStackRequestActionSerializer());
        $codec->register(DimensionData::class, new DimensionDataSerializer());
        $codec->register(DropStackRequestAction::class, new DropStackRequestActionSerializer());
        $codec->register(EducationSettingsAgentCapabilities::class, new EducationSettingsAgentCapabilitiesSerializer());
        $codec->register(EducationSettingsExternalLinkSettings::class, new EducationSettingsExternalLinkSettingsSerializer());
        $codec->register(EducationUriResource::class, new EducationUriResourceSerializer());
        $codec->register(Enchant::class, new EnchantSerializer());
        $codec->register(EnchantOption::class, new EnchantOptionSerializer());
        $codec->register(Experiments::class, new ExperimentsSerializer());
        $codec->register(FeatureRegistryPacketEntry::class, new FeatureRegistryPacketEntrySerializer());
        $codec->register(FloatGameRule::class, new FloatGameRuleSerializer());
        $codec->register(FullContainerName::class, new FullContainerNameSerializer());
        $codec->register(FurnaceRecipe::class, new FurnaceRecipeSerializer());
        $codec->register(GrindstoneStackRequestAction::class, new GrindstoneStackRequestActionSerializer());
        $codec->register(IntGameRule::class, new IntGameRuleSerializer());
        $codec->register(IntIdMetaItemDescriptor::class, new IntIdMetaItemDescriptorSerializer());
        $codec->register(InventoryTransactionChangedSlotsHack::class, new InventoryTransactionChangedSlotsHackSerializer());
        $codec->register(ItemInteractionData::class, new ItemInteractionDataSerializer());
        $codec->register(ItemStack::class, new ItemStackSerializer());
        $codec->register(ItemStackRequestSlotInfo::class, new ItemStackRequestSlotInfoSerializer());
        $codec->register(ItemStackResponseContainerInfo::class, new ItemStackResponseContainerInfoSerializer());
        $codec->register(ItemStackResponseSlotInfo::class, new ItemStackResponseSlotInfoSerializer());
        $codec->register(ItemStackWrapper::class, new ItemStackWrapperSerializer());
        $codec->register(ItemTypeEntry::class, new ItemTypeEntrySerializer());
        $codec->register(LabTableCombineStackRequestAction::class, new LabTableCombineStackRequestActionSerializer());
        $codec->register(LevelSettingsData::class, new LevelSettingsDataSerializer());
        $codec->register(LoomStackRequestAction::class, new LoomStackRequestActionSerializer());
        $codec->register(MapDecoration::class, new MapDecorationSerializer());
        $codec->register(MapImage::class, new MapImageSerializer());
        $codec->register(MapInfoRequestPacketClientPixel::class, new MapInfoRequestPacketClientPixelSerializer());
        $codec->register(MapTrackedObject::class, new MapTrackedObjectSerializer());
        $codec->register(MaterialReducerRecipe::class, new MaterialReducerRecipeSerializer());
        $codec->register(MaterialReducerRecipeOutput::class, new MaterialReducerRecipeOutputSerializer());
        $codec->register(MineBlockStackRequestAction::class, new MineBlockStackRequestActionSerializer());
        $codec->register(MismatchTransactionData::class, new MismatchTransactionDataSerializer());
        $codec->register(MolangItemDescriptor::class, new MolangItemDescriptorSerializer());
        $codec->register(MultiRecipe::class, new MultiRecipeSerializer());
        $codec->register(NetworkInventoryAction::class, new NetworkInventoryActionSerializer());
        $codec->register(NetworkPermissionsData::class, new NetworkPermissionsSerializer());
        $codec->register(NormalTransactionData::class, new NormalTransactionDataSerializer());
        $codec->register(PacketShapeData::class, new PacketShapeDataSerializer());
        $codec->register(PersonaPieceTintColor::class, new PersonaPieceTintColorSerializer());
        $codec->register(PersonaSkinPiece::class, new PersonaSkinPieceSerializer());
        $codec->register(PlaceStackRequestAction::class, new PlaceStackRequestActionSerializer());
        $codec->register(PlayerMovementSettingsData::class, new PlayerMovementSettingsSerializer());
        $codec->register(PotionContainerChangeRecipe::class, new PotionContainerChangeRecipeSerializer());
        $codec->register(PotionTypeRecipe::class, new PotionTypeRecipeSerializer());
        $codec->register(PropertySyncData::class, new PropertySyncDataSerializer());
        $codec->register(RecipeIngredient::class, new RecipeIngredientSerializer());
        $codec->register(RecipeUnlockingRequirement::class, new RecipeUnlockingRequirementSerializer());
        $codec->register(RecipeWithTypeId::class, new RecipeWithTypeIdSerializer());
        $codec->register(ReleaseItemTransactionData::class, new ReleaseItemTransactionDataSerializer());
        $codec->register(ResourcePackInfoEntry::class, new ResourcePackInfoEntrySerializer());
        $codec->register(ResourcePackStackEntry::class, new ResourcePackStackEntrySerializer());
        $codec->register(ScorePacketEntry::class, new ScorePacketEntrySerializer());
        $codec->register(ScoreboardIdentityPacketEntry::class, new ScoreboardIdentityPacketEntrySerializer());
        $codec->register(ShapedRecipe::class, new ShapedRecipeSerializer());
        $codec->register(ShapelessRecipe::class, new ShapelessRecipeSerializer());
        $codec->register(SkinAnimation::class, new SkinAnimationSerializer());
        $codec->register(SkinData::class, new SkinDataSerializer());
        $codec->register(SkinImage::class, new SkinImageSerializer());
        $codec->register(SmithingTransformRecipe::class, new SmithingTransformRecipeSerializer());
        $codec->register(SmithingTrimRecipe::class, new SmithingTrimRecipeSerializer());
        $codec->register(StringIdMetaItemDescriptor::class, new StringIdMetaItemDescriptorSerializer());
        $codec->register(StructureEditorData::class, new StructureEditorDataSerializer());
        $codec->register(StructureSettings::class, new StructureSettingsSerializer());
        $codec->register(SubChunkPacketEntryCommon::class, new SubChunkPacketEntryCommonSerializer());
        $codec->register(SubChunkPacketHeightMapInfo::class, new SubChunkPacketHeightMapInfoSerializer());
        $codec->register(SubChunkPosition::class, new SubChunkPositionSerializer());
        $codec->register(SubChunkPositionOffset::class, new SubChunkPositionOffsetSerializer());
        $codec->register(SwapStackRequestAction::class, new SwapStackRequestActionSerializer());
        $codec->register(TagItemDescriptor::class, new TagItemDescriptorSerializer());
        $codec->register(TakeStackRequestAction::class, new TakeStackRequestActionSerializer());
        $codec->register(TransactionData::class, new InventoryTransactionDataSerializer());
        $codec->register(TrimMaterial::class, new TrimMaterialSerializer());
        $codec->register(TrimPattern::class, new TrimPatternSerializer());
        $codec->register(UpdateAttribute::class, new UpdateAttributeSerializer());
        $codec->register(UpdateSubChunkBlocksPacketEntry::class, new UpdateSubChunkBlocksPacketEntrySerializer());
        $codec->register(UseItemOnEntityTransactionData::class, new UseItemOnEntityTransactionDataSerializer());
        $codec->register(UseItemTransactionData::class, new UseItemTransactionDataSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return CodecBuilder::create(ProtocolVersion::v844, $mc?->__toString() ?? "1.21.111", self::buildCodecType())
            ->register(LoginPacket::ID, new LoginCodec())
            ->register(PlayStatusPacket::ID, new PlayStatusCodec())
            ->register(ServerToClientHandshakePacket::ID, new ServerToClientHandshakeCodec())
            ->register(ClientToServerHandshakePacket::ID, new ClientToServerHandshakeCodec())
            ->register(DisconnectPacket::ID, new DisconnectCodec())
            ->register(ResourcePacksInfoPacket::ID, new ResourcePacksInfoCodec())
            ->register(ResourcePackStackPacket::ID, new ResourcePackStackCodec())
            ->register(ResourcePackClientResponsePacket::ID, new ResourcePackClientResponseCodec())
            ->register(TextPacket::ID, new TextCodec())
            ->register(SetTimePacket::ID, new SetTimeCodec())
            ->register(StartGamePacket::ID, new StartGameCodec())
            ->register(AddPlayerPacket::ID, new AddPlayerCodec())
            ->register(AddActorPacket::ID, new AddActorCodec())
            ->register(RemoveActorPacket::ID, new RemoveActorCodec())
            ->register(AddItemActorPacket::ID, new AddItemActorCodec())
            ->register(ServerPlayerPostMovePositionPacket::ID, new ServerPlayerPostMovePositionCodec())
            ->register(TakeItemActorPacket::ID, new TakeItemActorCodec())
            ->register(MoveActorAbsolutePacket::ID, new MoveActorAbsoluteCodec())
            ->register(MovePlayerPacket::ID, new MovePlayerCodec())
            ->register(UpdateBlockPacket::ID, new UpdateBlockCodec())
            ->register(AddPaintingPacket::ID, new AddPaintingCodec())
            ->register(LevelEventPacket::ID, new LevelEventCodec())
            ->register(BlockEventPacket::ID, new BlockEventCodec())
            ->register(ActorEventPacket::ID, new ActorEventCodec())
            ->register(MobEffectPacket::ID, new MobEffectCodec())
            ->register(UpdateAttributesPacket::ID, new UpdateAttributesCodec())
            ->register(InventoryTransactionPacket::ID, new InventoryTransactionCodec())
            ->register(MobEquipmentPacket::ID, new MobEquipmentCodec())
            ->register(MobArmorEquipmentPacket::ID, new MobArmorEquipmentCodec())
            ->register(InteractPacket::ID, new InteractCodec())
            ->register(BlockPickRequestPacket::ID, new BlockPickRequestCodec())
            ->register(ActorPickRequestPacket::ID, new ActorPickRequestCodec())
            ->register(PlayerActionPacket::ID, new PlayerActionCodec())
            ->register(HurtArmorPacket::ID, new HurtArmorCodec())
            ->register(SetActorDataPacket::ID, new SetActorDataCodec())
            ->register(SetActorMotionPacket::ID, new SetActorMotionCodec())
            ->register(SetActorLinkPacket::ID, new SetActorLinkCodec())
            ->register(SetHealthPacket::ID, new SetHealthCodec())
            ->register(SetSpawnPositionPacket::ID, new SetSpawnPositionCodec())
            ->register(AnimatePacket::ID, new AnimateCodec())
            ->register(RespawnPacket::ID, new RespawnCodec())
            ->register(ContainerOpenPacket::ID, new ContainerOpenCodec())
            ->register(ContainerClosePacket::ID, new ContainerCloseCodec())
            ->register(PlayerHotbarPacket::ID, new PlayerHotbarCodec())
            ->register(InventoryContentPacket::ID, new InventoryContentCodec())
            ->register(InventorySlotPacket::ID, new InventorySlotCodec())
            ->register(ContainerSetDataPacket::ID, new ContainerSetDataCodec())
            ->register(CraftingDataPacket::ID, new CraftingDataCodec())
            ->register(GuiDataPickItemPacket::ID, new GuiDataPickItemCodec())
            ->register(BlockActorDataPacket::ID, new BlockActorDataCodec())
            ->register(LevelChunkPacket::ID, new LevelChunkCodec())
            ->register(SetCommandsEnabledPacket::ID, new SetCommandsEnabledCodec())
            ->register(SetDifficultyPacket::ID, new SetDifficultyCodec())
            ->register(ChangeDimensionPacket::ID, new ChangeDimensionCodec())
            ->register(SetPlayerGameTypePacket::ID, new SetPlayerGameTypeCodec())
            ->register(PlayerListPacket::ID, new PlayerListCodec())
            ->register(SimpleEventPacket::ID, new SimpleEventCodec())
            ->register(LegacyTelemetryEventPacket::ID, new LegacyTelemetryEventCodec())
            ->register(SpawnExperienceOrbPacket::ID, new SpawnExperienceOrbCodec())
            ->register(ClientboundMapItemDataPacket::ID, new ClientboundMapItemDataCodec())
            ->register(MapInfoRequestPacket::ID, new MapInfoRequestCodec())
            ->register(RequestChunkRadiusPacket::ID, new RequestChunkRadiusCodec())
            ->register(ChunkRadiusUpdatedPacket::ID, new ChunkRadiusUpdatedCodec())
            ->register(GameRulesChangedPacket::ID, new GameRulesChangedCodec())
            ->register(CameraPacket::ID, new CameraCodec())
            ->register(BossEventPacket::ID, new BossEventCodec())
            ->register(ShowCreditsPacket::ID, new ShowCreditsCodec())
            ->register(AvailableCommandsPacket::ID, new AvailableCommandsCodec())
            ->register(CommandRequestPacket::ID, new CommandRequestCodec())
            ->register(CommandBlockUpdatePacket::ID, new CommandBlockUpdateCodec())
            ->register(CommandOutputPacket::ID, new CommandOutputCodec())
            ->register(UpdateTradePacket::ID, new UpdateTradeCodec())
            ->register(UpdateEquipPacket::ID, new UpdateEquipCodec())
            ->register(ResourcePackDataInfoPacket::ID, new ResourcePackDataInfoCodec())
            ->register(ResourcePackChunkDataPacket::ID, new ResourcePackChunkDataCodec())
            ->register(ResourcePackChunkRequestPacket::ID, new ResourcePackChunkRequestCodec())
            ->register(TransferPacket::ID, new TransferCodec())
            ->register(PlaySoundPacket::ID, new PlaySoundCodec())
            ->register(StopSoundPacket::ID, new StopSoundCodec())
            ->register(SetTitlePacket::ID, new SetTitleCodec())
            ->register(AddBehaviorTreePacket::ID, new AddBehaviorTreeCodec())
            ->register(StructureBlockUpdatePacket::ID, new StructureBlockUpdateCodec())
            ->register(ShowStoreOfferPacket::ID, new ShowStoreOfferCodec())
            ->register(PurchaseReceiptPacket::ID, new PurchaseReceiptCodec())
            ->register(PlayerSkinPacket::ID, new PlayerSkinCodec())
            ->register(SubClientLoginPacket::ID, new SubClientLoginCodec())
            ->register(AutomationClientConnectPacket::ID, new AutomationClientConnectCodec())
            ->register(SetLastHurtByPacket::ID, new SetLastHurtByCodec())
            ->register(BookEditPacket::ID, new BookEditCodec())
            ->register(NpcRequestPacket::ID, new NpcRequestCodec())
            ->register(PhotoTransferPacket::ID, new PhotoTransferCodec())
            ->register(ModalFormRequestPacket::ID, new ModalFormRequestCodec())
            ->register(ModalFormResponsePacket::ID, new ModalFormResponseCodec())
            ->register(ServerSettingsRequestPacket::ID, new ServerSettingsRequestCodec())
            ->register(ServerSettingsResponsePacket::ID, new ServerSettingsResponseCodec())
            ->register(ShowProfilePacket::ID, new ShowProfileCodec())
            ->register(SetDefaultGameTypePacket::ID, new SetDefaultGameTypeCodec())
            ->register(RemoveObjectivePacket::ID, new RemoveObjectiveCodec())
            ->register(SetDisplayObjectivePacket::ID, new SetDisplayObjectiveCodec())
            ->register(SetScorePacket::ID, new SetScoreCodec())
            ->register(LabTablePacket::ID, new LabTableCodec())
            ->register(UpdateBlockSyncedPacket::ID, new UpdateBlockSyncedCodec())
            ->register(MoveActorDeltaPacket::ID, new MoveActorDeltaCodec())
            ->register(SetScoreboardIdentityPacket::ID, new SetScoreboardIdentityCodec())
            ->register(SetLocalPlayerAsInitializedPacket::ID, new SetLocalPlayerAsInitializedCodec())
            ->register(UpdateSoftEnumPacket::ID, new UpdateSoftEnumCodec())
            ->register(NetworkStackLatencyPacket::ID, new NetworkStackLatencyCodec())
            ->register(SpawnParticleEffectPacket::ID, new SpawnParticleEffectCodec())
            ->register(AvailableActorIdentifiersPacket::ID, new AvailableActorIdentifiersCodec())
            ->register(NetworkChunkPublisherUpdatePacket::ID, new NetworkChunkPublisherUpdateCodec())
            ->register(BiomeDefinitionListPacket::ID, new BiomeDefinitionListCodec())
            ->register(LevelSoundEventPacket::ID, new LevelSoundEventCodec())
            ->register(LevelEventGenericPacket::ID, new LevelEventGenericCodec())
            ->register(LecternUpdatePacket::ID, new LecternUpdateCodec())
            ->register(ClientCacheStatusPacket::ID, new ClientCacheStatusCodec())
            ->register(OnScreenTextureAnimationPacket::ID, new OnScreenTextureAnimationCodec())
            ->register(MapCreateLockedCopyPacket::ID, new MapCreateLockedCopyCodec())
            ->register(StructureTemplateDataRequestPacket::ID, new StructureTemplateDataRequestCodec())
            ->register(StructureTemplateDataResponsePacket::ID, new StructureTemplateDataResponseCodec())
            ->register(ClientCacheBlobStatusPacket::ID, new ClientCacheBlobStatusCodec())
            ->register(ClientCacheMissResponsePacket::ID, new ClientCacheMissResponseCodec())
            ->register(EducationSettingsPacket::ID, new EducationSettingsCodec())
            ->register(EmotePacket::ID, new EmoteCodec())
            ->register(MultiplayerSettingsPacket::ID, new MultiplayerSettingsCodec())
            ->register(SettingsCommandPacket::ID, new SettingsCommandCodec())
            ->register(AnvilDamagePacket::ID, new AnvilDamageCodec())
            ->register(CompletedUsingItemPacket::ID, new CompletedUsingItemCodec())
            ->register(NetworkSettingsPacket::ID, new NetworkSettingsCodec())
            ->register(PlayerAuthInputPacket::ID, new PlayerAuthInputCodec())
            ->register(CreativeContentPacket::ID, new CreativeContentCodec())
            ->register(PlayerEnchantOptionsPacket::ID, new PlayerEnchantOptionsCodec())
            ->register(ItemStackRequestPacket::ID, new ItemStackRequestCodec())
            ->register(ItemStackResponsePacket::ID, new ItemStackResponseCodec())
            ->register(PlayerArmorDamagePacket::ID, new PlayerArmorDamageCodec())
            ->register(CodeBuilderPacket::ID, new CodeBuilderCodec())
            ->register(UpdatePlayerGameTypePacket::ID, new UpdatePlayerGameTypeCodec())
            ->register(EmoteListPacket::ID, new EmoteListCodec())
            ->register(PositionTrackingDBServerBroadcastPacket::ID, new PositionTrackingDBServerBroadcastCodec())
            ->register(PositionTrackingDBClientRequestPacket::ID, new PositionTrackingDBClientRequestCodec())
            ->register(DebugInfoPacket::ID, new DebugInfoCodec())
            ->register(PacketViolationWarningPacket::ID, new PacketViolationWarningCodec())
            ->register(MotionPredictionHintsPacket::ID, new MotionPredictionHintsCodec())
            ->register(AnimateEntityPacket::ID, new AnimateEntityCodec())
            ->register(CameraShakePacket::ID, new CameraShakeCodec())
            ->register(PlayerFogPacket::ID, new PlayerFogCodec())
            ->register(CorrectPlayerMovePredictionPacket::ID, new CorrectPlayerMovePredictionCodec())
            ->register(ItemRegistryPacket::ID, new ItemRegistryCodec())
            ->register(ClientboundDebugRendererPacket::ID, new ClientboundDebugRendererCodec())
            ->register(SyncActorPropertyPacket::ID, new SyncActorPropertyCodec())
            ->register(AddVolumeEntityPacket::ID, new AddVolumeEntityCodec())
            ->register(RemoveVolumeEntityPacket::ID, new RemoveVolumeEntityCodec())
            ->register(SimulationTypePacket::ID, new SimulationTypeCodec())
            ->register(NpcDialoguePacket::ID, new NpcDialogueCodec())
            ->register(EduUriResourcePacket::ID, new EduUriResourceCodec())
            ->register(CreatePhotoPacket::ID, new CreatePhotoCodec())
            ->register(UpdateSubChunkBlocksPacket::ID, new UpdateSubChunkBlocksCodec())
            ->register(SubChunkPacket::ID, new SubChunkCodec())
            ->register(SubChunkRequestPacket::ID, new SubChunkRequestCodec())
            ->register(PlayerStartItemCooldownPacket::ID, new PlayerStartItemCooldownCodec())
            ->register(ScriptMessagePacket::ID, new ScriptMessageCodec())
            ->register(CodeBuilderSourcePacket::ID, new CodeBuilderSourceCodec())
            ->register(TickingAreasLoadStatusPacket::ID, new TickingAreasLoadStatusCodec())
            ->register(DimensionDataPacket::ID, new DimensionDataCodec())
            ->register(AgentActionEventPacket::ID, new AgentActionEventCodec())
            ->register(ChangeMobPropertyPacket::ID, new ChangeMobPropertyCodec())
            ->register(LessonProgressPacket::ID, new LessonProgressCodec())
            ->register(RequestAbilityPacket::ID, new RequestAbilityCodec())
            ->register(RequestPermissionsPacket::ID, new RequestPermissionsCodec())
            ->register(ToastRequestPacket::ID, new ToastRequestCodec())
            ->register(UpdateAbilitiesPacket::ID, new UpdateAbilitiesCodec())
            ->register(UpdateAdventureSettingsPacket::ID, new UpdateAdventureSettingsCodec())
            ->register(DeathInfoPacket::ID, new DeathInfoCodec())
            ->register(EditorNetworkPacket::ID, new EditorNetworkCodec())
            ->register(FeatureRegistryPacket::ID, new FeatureRegistryCodec())
            ->register(ServerStatsPacket::ID, new ServerStatsCodec())
            ->register(RequestNetworkSettingsPacket::ID, new RequestNetworkSettingsCodec())
            ->register(GameTestRequestPacket::ID, new GameTestRequestCodec())
            ->register(GameTestResultsPacket::ID, new GameTestResultsCodec())
            ->register(UpdateClientInputLocksPacket::ID, new UpdateClientInputLocksCodec())
            ->register(CameraPresetsPacket::ID, new CameraPresetsCodec())
            ->register(UnlockedRecipesPacket::ID, new UnlockedRecipesCodec())
            ->register(CameraInstructionPacket::ID, new CameraInstructionCodec())
            ->register(TrimDataPacket::ID, new TrimDataCodec())
            ->register(OpenSignPacket::ID, new OpenSignCodec())
            ->register(AgentAnimationPacket::ID, new AgentAnimationCodec())
            ->register(RefreshEntitlementsPacket::ID, new RefreshEntitlementsCodec())
            ->register(PlayerToggleCrafterSlotRequestPacket::ID, new PlayerToggleCrafterSlotRequestCodec())
            ->register(SetPlayerInventoryOptionsPacket::ID, new SetPlayerInventoryOptionsCodec())
            ->register(SetHudPacket::ID, new SetHudCodec())
            ->register(AwardAchievementPacket::ID, new AwardAchievementCodec())
            ->register(ClientboundCloseFormPacket::ID, new ClientboundCloseFormCodec())
            ->register(ServerboundLoadingScreenPacket::ID, new ServerboundLoadingScreenCodec())
            ->register(JigsawStructureDataPacket::ID, new JigsawStructureDataCodec())
            ->register(CurrentStructureFeaturePacket::ID, new CurrentStructureFeatureCodec())
            ->register(ServerboundDiagnosticsPacket::ID, new ServerboundDiagnosticsCodec())
            ->register(CameraAimAssistPacket::ID, new CameraAimAssistCodec())
            ->register(ContainerRegistryCleanupPacket::ID, new ContainerRegistryCleanupCodec())
            ->register(MovementEffectPacket::ID, new MovementEffectCodec())
            ->register(CameraAimAssistPresetsPacket::ID, new CameraAimAssistPresetsCodec())
            ->register(ClientCameraAimAssistPacket::ID, new ClientCameraAimAssistCodec())
            ->register(ClientMovementPredictionSyncPacket::ID, new ClientMovementPredictionSyncCodec())
            ->register(UpdateClientOptionsPacket::ID, new UpdateClientOptionsCodec())
            ->register(PlayerVideoCapturePacket::ID, new PlayerVideoCaptureCodec())
            ->register(PlayerUpdateEntityOverridesPacket::ID, new PlayerUpdateEntityOverridesCodec())
            ->register(PlayerLocationPacket::ID, new PlayerLocationCodec())
            ->register(ClientboundControlSchemeSetPacket::ID, new ClientboundControlSchemeSetCodec())
            ->register(PrimitiveShapesPacket::ID, new PrimitiveShapesCodec())
            ->register(ServerboundPackSettingChangePacket::ID, new ServerboundPackSettingChangeCodec());
    }
}
