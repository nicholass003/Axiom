<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\InventoryTransactionChangedSlotsHack;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class InventoryTransactionChangedSlotsHackSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : InventoryTransactionChangedSlotsHack{
		$containerId = VarInt::readUnsignedInt($in);
		$changedSlotIndexes = CodecHelper::readList($in, fn($in) => VarInt::readSignedInt($in));

		return new InventoryTransactionChangedSlotsHack(
			containerId: $containerId,
			changedSlotIndexes: $changedSlotIndexes
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof InventoryTransactionChangedSlotsHack);

		VarInt::writeUnsignedInt($out, $data->containerId);
		CodecHelper::writeList($out, $data->changedSlotIndexes, fn($out, $v) => VarInt::writeSignedInt($out, $v));
	}
}
