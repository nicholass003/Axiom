<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class UseItemOnEntityTransactionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : UseItemOnEntityTransactionData{
		$actions = CodecHelper::readList($in, fn($in) => $codec->read(NetworkInventoryAction::class, $in));

		return new UseItemOnEntityTransactionData(
			$actions,
			CodecHelper::readActorRuntimeId($in),
			VarInt::readUnsignedInt($in),
			VarInt::readSignedInt($in),
			$codec->read(ItemStackWrapper::class, $in),
			CodecHelper::readVec3($in),
			CodecHelper::readVec3($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof UseItemOnEntityTransactionData);

		CodecHelper::writeList($out, $data->actions, fn($out, $a) => $codec->write(NetworkInventoryAction::class, $out, $a));
		CodecHelper::writeActorRuntimeId($out, $data->actorRuntimeId);
		VarInt::writeUnsignedInt($out, $data->actionType);
		VarInt::writeSignedInt($out, $data->hotbarSlot);
		$codec->write(ItemStackWrapper::class, $out, $data->itemInHand);
		CodecHelper::writeVec3($out, $data->playerPosition);
		CodecHelper::writeVec3($out, $data->clickPosition);
	}
}
