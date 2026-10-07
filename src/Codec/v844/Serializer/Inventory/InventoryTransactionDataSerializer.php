<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData;
use Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData;
use Nicholass003\Axiom\Enum\InventoryTransactionType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class InventoryTransactionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : TransactionData{
		$raw = VarInt::readUnsignedInt($in);
		$type = InventoryTransactionType::safe($raw);
		if($type === InventoryTransactionType::UNKNOWN){
			throw new \RuntimeException("Unknown transaction type $raw");
		}

		return match($type){
			InventoryTransactionType::NORMAL => $codec->read(NormalTransactionData::class, $in),
			InventoryTransactionType::MISMATCH => $codec->read(MismatchTransactionData::class, $in),
			InventoryTransactionType::USE_ITEM => $codec->read(UseItemTransactionData::class, $in),
			InventoryTransactionType::USE_ITEM_ON_ENTITY => $codec->read(UseItemOnEntityTransactionData::class, $in),
			InventoryTransactionType::RELEASE_ITEM => $codec->read(ReleaseItemTransactionData::class, $in),
			InventoryTransactionType::UNKNOWN => throw new \RuntimeException("Unknown transaction type")
		};
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof TransactionData);

		$type = match(true){
			$data instanceof NormalTransactionData => InventoryTransactionType::NORMAL,
			$data instanceof MismatchTransactionData => InventoryTransactionType::MISMATCH,
			$data instanceof UseItemTransactionData => InventoryTransactionType::USE_ITEM,
			$data instanceof UseItemOnEntityTransactionData => InventoryTransactionType::USE_ITEM_ON_ENTITY,
			$data instanceof ReleaseItemTransactionData => InventoryTransactionType::RELEASE_ITEM,
			default => throw new \InvalidArgumentException("Unknown transaction data type")
		};
		VarInt::writeUnsignedInt($out, $type->value);

		match(true){
			$data instanceof NormalTransactionData => $codec->write(NormalTransactionData::class, $out, $data),
			$data instanceof MismatchTransactionData => $codec->write(MismatchTransactionData::class, $out, $data),
			$data instanceof UseItemTransactionData => $codec->write(UseItemTransactionData::class, $out, $data),
			$data instanceof UseItemOnEntityTransactionData => $codec->write(UseItemOnEntityTransactionData::class, $out, $data),
			$data instanceof ReleaseItemTransactionData => $codec->write(ReleaseItemTransactionData::class, $out, $data),
			default => throw new \InvalidArgumentException("Unknown transaction data type")
		};
	}
}
