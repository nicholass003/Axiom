<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Enum\HandSlot;
use Nicholass003\Axiom\Enum\PredictedResult;
use Nicholass003\Axiom\Enum\TriggerType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class UseItemTransactionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : UseItemTransactionData{
		$actions = CodecHelper::readList($in, fn($in) => $codec->read(NetworkInventoryAction::class, $in));

		$actionType = VarInt::readUnsignedInt($in);
		$triggerRaw = Byte::readUnsigned($in);
		$triggerType = TriggerType::safe($triggerRaw);
		if($triggerType === TriggerType::INVALID){
			throw new \RuntimeException("Invalid trigger type $triggerRaw");
		}
		$blockPosition = CodecHelper::readSignedBlockPosition($in);
		$face = VarInt::readSignedInt($in);
		$hotbarSlot = VarInt::readSignedInt($in);
		$itemInHand = $codec->read(ItemStackWrapper::class, $in);
		$playerPosition = CodecHelper::readVec3($in);
		$clickPosition = CodecHelper::readVec3($in);
		$blockRuntimeId = VarInt::readUnsignedInt($in);
		$predictedRaw = Byte::readUnsigned($in);
		$predictedResult = PredictedResult::safe($predictedRaw);
		if($predictedResult === PredictedResult::UNKNOWN){
			throw new \RuntimeException("Invalid predicted result $predictedRaw");
		}
		$clientCooldownState = Byte::readUnsigned($in);

		return new UseItemTransactionData(
			actions: $actions,
			actionType: $actionType,
			triggerType: $triggerType,
			blockPosition: $blockPosition,
			face: $face,
			hotbarSlot: $hotbarSlot,
			hand: HandSlot::MAINHAND,
			itemInHand: $itemInHand,
			playerPosition: $playerPosition,
			clickPosition: $clickPosition,
			blockRuntimeId: $blockRuntimeId,
			clientInteractPrediction: $predictedResult,
			clientCooldownState: $clientCooldownState
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof UseItemTransactionData);

		CodecHelper::writeList($out, $data->actions, fn($out, $a) => $codec->write(NetworkInventoryAction::class, $out, $a));
		VarInt::writeUnsignedInt($out, $data->actionType);
		Byte::writeUnsigned($out, $data->triggerType->value);
		CodecHelper::writeSignedBlockPosition($out, $data->blockPosition);
		VarInt::writeSignedInt($out, $data->face);
		VarInt::writeSignedInt($out, $data->hotbarSlot);
		$codec->write(ItemStackWrapper::class, $out, $data->itemInHand);
		CodecHelper::writeVec3($out, $data->playerPosition);
		CodecHelper::writeVec3($out, $data->clickPosition);
		VarInt::writeUnsignedInt($out, $data->blockRuntimeId);
		Byte::writeUnsigned($out, $data->clientInteractPrediction->value);
		Byte::writeUnsigned($out, $data->clientCooldownState);
	}
}
