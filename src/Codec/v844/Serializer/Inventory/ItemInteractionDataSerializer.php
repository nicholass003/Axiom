<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\InventoryTransactionChangedSlotsHack;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use Nicholass003\Axiom\Data\Type\ItemInteractionData;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ItemInteractionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemInteractionData{
		$requestId = VarInt::readSignedInt($in);
		$changedSlots = [];
		if($requestId !== 0){
			$changedSlots = CodecHelper::readList($in, function(ByteBufferReader $in) : InventoryTransactionChangedSlotsHack{
				return new InventoryTransactionChangedSlotsHack(
					Byte::readUnsigned($in),
					CodecHelper::readList($in, fn($in) => Byte::readUnsigned($in))
				);
			});
		}
		$transactionData = $codec->read(TransactionData::class, $in);
		return new ItemInteractionData($requestId, $changedSlots, $transactionData);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemInteractionData);

		VarInt::writeSignedInt($out, $data->requestId);
		if($data->requestId !== 0){
			CodecHelper::writeList($out, $data->requestChangedSlots, function(ByteBufferWriter $out, InventoryTransactionChangedSlotsHack $changed) : void{
				Byte::writeUnsigned($out, $changed->containerId);
				CodecHelper::writeList($out, $changed->changedSlotIndexes, fn($out, $index) => Byte::writeUnsigned($out, $index));
			});
		}
		$codec->write(TransactionData::class, $out, $data->transactionData);
	}
}
