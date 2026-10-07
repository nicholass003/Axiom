<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\BlockPosition;
use Nicholass003\Axiom\Data\Type\BoolGameRule;
use Nicholass003\Axiom\Data\Type\Education\EducationUriResource;
use Nicholass003\Axiom\Data\Type\Experiments;
use Nicholass003\Axiom\Data\Type\FloatGameRule;
use Nicholass003\Axiom\Data\Type\IntGameRule;
use Nicholass003\Axiom\Data\Type\LevelSettingsData;
use Nicholass003\Axiom\Data\Type\SpawnSettings;
use Nicholass003\Axiom\Enum\GameRuleType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;
use pocketmine\utils\Binary;

class LevelSettingsDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : LevelSettingsData{
		$seed = LE::readUnsignedLong($in);

		$spawnSettings = new SpawnSettings(
			biomeType: LE::readUnsignedShort($in),
			biomeName: CodecHelper::readString($in),
			dimension: VarInt::readSignedInt($in)
		);

		$generator = VarInt::readSignedInt($in);
		$worldGamemode = VarInt::readSignedInt($in);
		$hardcore = CodecHelper::readBool($in);
		$difficulty = VarInt::readSignedInt($in);
		$spawnPosition = new BlockPosition(
			x: VarInt::readSignedInt($in),
			y: Binary::signInt(VarInt::readUnsignedInt($in)),
			z: VarInt::readSignedInt($in)
		);

		$hasAchievementsDisabled = CodecHelper::readBool($in);
		$editorWorldType = VarInt::readSignedInt($in);
		$createdInEditorMode = CodecHelper::readBool($in);
		$exportedFromEditorMode = CodecHelper::readBool($in);

		$time = VarInt::readSignedInt($in);
		$eduEditionOffer = VarInt::readSignedInt($in);
		$hasEduFeaturesEnabled = CodecHelper::readBool($in);
		$eduProductUUID = CodecHelper::readString($in);

		$rainLevel = LE::readFloat($in);
		$lightningLevel = LE::readFloat($in);
		$hasConfirmedPlatformLockedContent = CodecHelper::readBool($in);

		$isMultiplayerGame = CodecHelper::readBool($in);
		$hasLANBroadcast = CodecHelper::readBool($in);
		$xboxLiveBroadcastMode = VarInt::readSignedInt($in);
		$platformBroadcastMode = VarInt::readSignedInt($in);

		$commandsEnabled = CodecHelper::readBool($in);
		$isTexturePacksRequired = CodecHelper::readBool($in);

		$gameRules = [];
		$ruleCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $ruleCount; ++$i){
			$name = CodecHelper::readString($in);
			$isPlayerModifiable = CodecHelper::readBool($in);
			$type = GameRuleType::safe(VarInt::readUnsignedInt($in));
			$gameRules[$name] = match($type){
                GameRuleType::BOOL => $codec->get(BoolGameRule::class)->read($in, $codec, $isPlayerModifiable),
                GameRuleType::INT => $codec->get(IntGameRule::class)->read($in, $codec, false, $isPlayerModifiable),
                GameRuleType::FLOAT => $codec->get(FloatGameRule::class)->read($in, $codec, $isPlayerModifiable),
				default => throw new \RuntimeException("Unknown game rule type")
			};
		}

		$experiments = $codec->read(Experiments::class, $in);

		$hasBonusChestEnabled = CodecHelper::readBool($in);
		$hasStartWithMapEnabled = CodecHelper::readBool($in);

		$defaultPlayerPermission = VarInt::readSignedInt($in);
		$serverChunkTickRadius = LE::readSignedInt($in);

		$hasLockedBehaviorPack = CodecHelper::readBool($in);
		$hasLockedResourcePack = CodecHelper::readBool($in);
		$isFromLockedWorldTemplate = CodecHelper::readBool($in);
		$useMsaGamertagsOnly = CodecHelper::readBool($in);
		$isFromWorldTemplate = CodecHelper::readBool($in);
		$isWorldTemplateOptionLocked = CodecHelper::readBool($in);
		$onlySpawnV1Villagers = CodecHelper::readBool($in);
		$disablePersona = CodecHelper::readBool($in);
		$disableCustomSkins = CodecHelper::readBool($in);
		$muteEmoteAnnouncements = CodecHelper::readBool($in);

		$vanillaVersion = CodecHelper::readString($in);

		$limitedWorldWidth = LE::readSignedInt($in);
		$limitedWorldLength = LE::readSignedInt($in);
		$isNewNether = CodecHelper::readBool($in);

		$eduSharedUriResource = $codec->read(EducationUriResource::class, $in);
		$experimentalGameplayOverride = CodecHelper::readOptional($in, CodecHelper::readBool(...));

		$chatRestrictionLevel = Byte::readUnsigned($in);
		$disablePlayerInteractions = CodecHelper::readBool($in);

		return new LevelSettingsData(
			seed: $seed,
			spawnSettings: $spawnSettings,
			generator: $generator,
			worldGamemode: $worldGamemode,
			hardcore: $hardcore,
			difficulty: $difficulty,
			spawnPosition: $spawnPosition,
			hasAchievementsDisabled: $hasAchievementsDisabled,
			editorWorldType: $editorWorldType,
			createdInEditorMode: $createdInEditorMode,
			exportedFromEditorMode: $exportedFromEditorMode,
			time: $time,
			eduEditionOffer: $eduEditionOffer,
			hasEduFeaturesEnabled: $hasEduFeaturesEnabled,
			eduProductUUID: $eduProductUUID,
			rainLevel: $rainLevel,
			lightningLevel: $lightningLevel,
			hasConfirmedPlatformLockedContent: $hasConfirmedPlatformLockedContent,
			isMultiplayerGame: $isMultiplayerGame,
			hasLANBroadcast: $hasLANBroadcast,
			xboxLiveBroadcastMode: $xboxLiveBroadcastMode,
			platformBroadcastMode: $platformBroadcastMode,
			commandsEnabled: $commandsEnabled,
			isTexturePacksRequired: $isTexturePacksRequired,
			gameRules: $gameRules,
			experiments: $experiments,
			hasBonusChestEnabled: $hasBonusChestEnabled,
			hasStartWithMapEnabled: $hasStartWithMapEnabled,
			defaultPlayerPermission: $defaultPlayerPermission,
			serverChunkTickRadius: $serverChunkTickRadius,
			hasLockedBehaviorPack: $hasLockedBehaviorPack,
			hasLockedResourcePack: $hasLockedResourcePack,
			isFromLockedWorldTemplate: $isFromLockedWorldTemplate,
			useMsaGamertagsOnly: $useMsaGamertagsOnly,
			isFromWorldTemplate: $isFromWorldTemplate,
			isWorldTemplateOptionLocked: $isWorldTemplateOptionLocked,
			onlySpawnV1Villagers: $onlySpawnV1Villagers,
			disablePersona: $disablePersona,
			disableCustomSkins: $disableCustomSkins,
			muteEmoteAnnouncements: $muteEmoteAnnouncements,
			vanillaVersion: $vanillaVersion,
			limitedWorldWidth: $limitedWorldWidth,
			limitedWorldLength: $limitedWorldLength,
			isNewNether: $isNewNether,
			eduSharedUriResource: $eduSharedUriResource,
			experimentalGameplayOverride: $experimentalGameplayOverride,
			chatRestrictionLevel: $chatRestrictionLevel,
			disablePlayerInteractions: $disablePlayerInteractions
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof LevelSettingsData);

		LE::writeUnsignedLong($out, $data->seed);

		LE::writeUnsignedShort($out, $data->spawnSettings->biomeType);
		CodecHelper::writeString($out, $data->spawnSettings->biomeName);
		VarInt::writeSignedInt($out, $data->spawnSettings->dimension);

		VarInt::writeSignedInt($out, $data->generator);
		VarInt::writeSignedInt($out, $data->worldGamemode);
		CodecHelper::writeBool($out, $data->hardcore);
		VarInt::writeSignedInt($out, $data->difficulty);
		VarInt::writeSignedInt($out, $data->spawnPosition->x);
		VarInt::writeUnsignedInt($out, Binary::unsignInt($data->spawnPosition->y));
		VarInt::writeSignedInt($out, $data->spawnPosition->z);

		CodecHelper::writeBool($out, $data->hasAchievementsDisabled);
		VarInt::writeSignedInt($out, $data->editorWorldType);
		CodecHelper::writeBool($out, $data->createdInEditorMode);
		CodecHelper::writeBool($out, $data->exportedFromEditorMode);

		VarInt::writeSignedInt($out, $data->time);
		VarInt::writeSignedInt($out, $data->eduEditionOffer);
		CodecHelper::writeBool($out, $data->hasEduFeaturesEnabled);
		CodecHelper::writeString($out, $data->eduProductUUID);

		LE::writeFloat($out, $data->rainLevel);
		LE::writeFloat($out, $data->lightningLevel);
		CodecHelper::writeBool($out, $data->hasConfirmedPlatformLockedContent);

		CodecHelper::writeBool($out, $data->isMultiplayerGame);
		CodecHelper::writeBool($out, $data->hasLANBroadcast);
		VarInt::writeSignedInt($out, $data->xboxLiveBroadcastMode);
		VarInt::writeSignedInt($out, $data->platformBroadcastMode);

		CodecHelper::writeBool($out, $data->commandsEnabled);
		CodecHelper::writeBool($out, $data->isTexturePacksRequired);

		VarInt::writeUnsignedInt($out, count($data->gameRules));
		foreach($data->gameRules as $name => $rule){
			CodecHelper::writeString($out, $name);
			CodecHelper::writeBool($out, $rule->isPlayerModifiable);
			$type = match(true){
				$rule instanceof BoolGameRule => GameRuleType::BOOL,
				$rule instanceof IntGameRule => GameRuleType::INT,
				$rule instanceof FloatGameRule => GameRuleType::FLOAT,
				default => throw new \InvalidArgumentException("Unknown game rule class")
			};
			VarInt::writeUnsignedInt($out, $type->value);
			match(true){
				$rule instanceof BoolGameRule => $codec->write(BoolGameRule::class, $out, $rule),
				$rule instanceof IntGameRule => $codec->write(IntGameRule::class, $out, $rule),
				$rule instanceof FloatGameRule => $codec->write(FloatGameRule::class, $out, $rule),
				default => throw new \InvalidArgumentException("Unknown game rule class")
			};
		}

		$codec->write(Experiments::class, $out, $data->experiments);

		CodecHelper::writeBool($out, $data->hasBonusChestEnabled);
		CodecHelper::writeBool($out, $data->hasStartWithMapEnabled);

		VarInt::writeSignedInt($out, $data->defaultPlayerPermission);
		LE::writeSignedInt($out, $data->serverChunkTickRadius);

		CodecHelper::writeBool($out, $data->hasLockedBehaviorPack);
		CodecHelper::writeBool($out, $data->hasLockedResourcePack);
		CodecHelper::writeBool($out, $data->isFromLockedWorldTemplate);
		CodecHelper::writeBool($out, $data->useMsaGamertagsOnly);
		CodecHelper::writeBool($out, $data->isFromWorldTemplate);
		CodecHelper::writeBool($out, $data->isWorldTemplateOptionLocked);
		CodecHelper::writeBool($out, $data->onlySpawnV1Villagers);
		CodecHelper::writeBool($out, $data->disablePersona);
		CodecHelper::writeBool($out, $data->disableCustomSkins);
		CodecHelper::writeBool($out, $data->muteEmoteAnnouncements);

		CodecHelper::writeString($out, $data->vanillaVersion);

		LE::writeSignedInt($out, $data->limitedWorldWidth);
		LE::writeSignedInt($out, $data->limitedWorldLength);
		CodecHelper::writeBool($out, $data->isNewNether);

		$codec->write(EducationUriResource::class, $out, $data->eduSharedUriResource ?? new EducationUriResource("", ""));
		CodecHelper::writeOptional($out, $data->experimentalGameplayOverride, CodecHelper::writeBool(...));

		Byte::writeUnsigned($out, $data->chatRestrictionLevel);
		CodecHelper::writeBool($out, $data->disablePlayerInteractions);
	}
}
