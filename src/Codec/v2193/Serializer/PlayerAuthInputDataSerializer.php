<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\BitSet;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequest;
use Nicholass003\Axiom\Data\Type\ItemInteractionData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputVehicleInfo;
use Nicholass003\Axiom\Data\Type\PlayerBlockActionData;
use Nicholass003\Axiom\Data\Type\Vec2;
use Nicholass003\Axiom\Enum\InputMode;
use Nicholass003\Axiom\Enum\PlayerAuthInputFlag;
use Nicholass003\Axiom\Enum\PlayMode;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PlayerAuthInputDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PlayerAuthInputData{
		$pitch = LE::readFloat($in);
		$yaw = LE::readFloat($in);
		$position = CodecHelper::readVec3($in);
		$moveX = LE::readFloat($in);
		$moveZ = LE::readFloat($in);
		$headYaw = LE::readFloat($in);

		$flagsList = CodecHelper::readList($in, VarInt::readSignedInt(...));
		$flags = new BitSet(PlayerAuthInputFlag::NUMBER_OF_FLAGS->value, []);
		foreach($flagsList as $flag){
			$flags = $flags->with($flag, true);
		}

		$inputMode = InputMode::safe(VarInt::readUnsignedInt($in));
		$playMode = PlayMode::safe(VarInt::readUnsignedInt($in));
		$interactionMode = VarInt::readSignedInt($in);
		$interactRotation = CodecHelper::readVec2($in);
		$tick = VarInt::readUnsignedLong($in);
		$delta = CodecHelper::readVec3($in);

		$itemInteraction = CodecHelper::readOptional($in, fn($i) => $codec->read(ItemInteractionData::class, $i));
		$itemStackRequest = CodecHelper::readOptional($in, fn($i) => $codec->read(ItemStackRequest::class, $i));
		$blockActions = CodecHelper::readOptional($in, static fn($in) => CodecHelper::readList($in, fn($i) => $codec->read(PlayerBlockActionData::class, $i)));

		$vehicleRotation = CodecHelper::readOptional($in, CodecHelper::readVec2(...));
		$vehicleActorUniqueId = CodecHelper::readOptional($in, CodecHelper::readActorUniqueId(...));
		$vehicleInfo = null;
		if($vehicleRotation !== null && $vehicleActorUniqueId !== null){
			$vehicleInfo = new PlayerAuthInputVehicleInfo(
				$vehicleRotation->x,
				$vehicleRotation->y,
				$vehicleActorUniqueId
			);
		}elseif($vehicleRotation === null && $vehicleActorUniqueId === null){
			$vehicleInfo = null;
		}else{
			throw new \RuntimeException("Vehicle rotation and actor unique ID must both be present or both be absent");
		}

		$analogX = LE::readFloat($in);
		$analogZ = LE::readFloat($in);
		$camera = CodecHelper::readVec3($in);
		$rawMove = CodecHelper::readVec2($in);

		return new PlayerAuthInputData(
			$position,
			$pitch,
			$yaw,
			$headYaw,
			$moveX,
			$moveZ,
			$flags,
			$inputMode,
			$playMode,
			$interactionMode,
			$interactRotation,
			$tick,
			$delta,
			$itemInteraction,
			$itemStackRequest,
			$blockActions,
			$vehicleInfo,
			$analogX,
			$analogZ,
			$camera,
			$rawMove
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PlayerAuthInputData);

		LE::writeFloat($out, $data->pitch);
		LE::writeFloat($out, $data->yaw);
		CodecHelper::writeVec3($out, $data->position);
		LE::writeFloat($out, $data->moveVecX);
		LE::writeFloat($out, $data->moveVecZ);
		LE::writeFloat($out, $data->headYaw);

		$flagsArray = [];
		for($i = 0; $i < PlayerAuthInputFlag::NUMBER_OF_FLAGS->value; ++$i){
			if($data->inputFlags->get($i)){
				$flagsArray[] = $i;
			}
		}
		CodecHelper::writeList($out, $flagsArray, fn($out, $v) => VarInt::writeSignedInt($out, $v));

		VarInt::writeUnsignedInt($out, $data->inputMode->value);
		VarInt::writeUnsignedInt($out, $data->playMode->value);
		VarInt::writeSignedInt($out, $data->interactionMode);
		CodecHelper::writeVec2($out, $data->interactRotation);
		VarInt::writeUnsignedLong($out, $data->tick);
		CodecHelper::writeVec3($out, $data->delta);

		CodecHelper::writeOptional($out, $data->itemInteractionData, static fn($out, $data) => $codec->write(ItemInteractionData::class, $out, $data));
		CodecHelper::writeOptional($out, $data->itemStackRequest, static fn($out, $request) => $codec->write(ItemStackRequest::class, $out, $request));
		CodecHelper::writeOptional($out, $data->blockActions, static fn($out, $actions) => CodecHelper::writeList($out, $actions, static fn($out, $action) => $codec->write(PlayerBlockActionData::class, $out, $action)));

		$vehicleRotation = $data->vehicleInfo !== null ? new Vec2($data->vehicleInfo->vehicleRotationX, $data->vehicleInfo->vehicleRotationZ) : null;
		CodecHelper::writeOptional($out, $vehicleRotation, CodecHelper::writeVec2(...));
		CodecHelper::writeOptional($out, $data->vehicleInfo !== null ? $data->vehicleInfo->predictedVehicleActorUniqueId : null, CodecHelper::writeActorUniqueId(...));

		LE::writeFloat($out, $data->analogMoveVecX);
		LE::writeFloat($out, $data->analogMoveVecZ);
		CodecHelper::writeVec3($out, $data->cameraOrientation);
		CodecHelper::writeVec2($out, $data->rawMove);
	}
}
