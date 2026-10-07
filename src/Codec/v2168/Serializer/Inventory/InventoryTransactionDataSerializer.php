<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\TransactionData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class InventoryTransactionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : TransactionData{
		$raw = VarInt::readUnsignedInt($in);
		$type = \Nicholass003\Axiom\Enum\InventoryTransactionType::safe($raw);
		if($type === \Nicholass003\Axiom\Enum\InventoryTransactionType::UNKNOWN){
			throw new \RuntimeException("Unknown transaction type $raw");
		}

		return match($type){
			\Nicholass003\Axiom\Enum\InventoryTransactionType::NORMAL => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData::class, $in),
			\Nicholass003\Axiom\Enum\InventoryTransactionType::MISMATCH => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData::class, $in),
			\Nicholass003\Axiom\Enum\InventoryTransactionType::USE_ITEM => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData::class, $in),
			\Nicholass003\Axiom\Enum\InventoryTransactionType::USE_ITEM_ON_ENTITY => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData::class, $in),
			\Nicholass003\Axiom\Enum\InventoryTransactionType::RELEASE_ITEM => $codec->read(\Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData::class, $in),
			\Nicholass003\Axiom\Enum\InventoryTransactionType::UNKNOWN => throw new \RuntimeException("Unknown transaction type")
		};
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof TransactionData);

		$type = match(true){
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData => \Nicholass003\Axiom\Enum\InventoryTransactionType::NORMAL,
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData => \Nicholass003\Axiom\Enum\InventoryTransactionType::MISMATCH,
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData => \Nicholass003\Axiom\Enum\InventoryTransactionType::USE_ITEM,
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData => \Nicholass003\Axiom\Enum\InventoryTransactionType::USE_ITEM_ON_ENTITY,
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData => \Nicholass003\Axiom\Enum\InventoryTransactionType::RELEASE_ITEM,
			default => throw new \InvalidArgumentException("Unknown transaction data type")
		};

		VarInt::writeUnsignedInt($out, $type->value);

		match(true){
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\NormalTransactionData::class, $out, $data),
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\MismatchTransactionData::class, $out, $data),
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\UseItemTransactionData::class, $out, $data),
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\UseItemOnEntityTransactionData::class, $out, $data),
			$data instanceof \Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData => $codec->write(\Nicholass003\Axiom\Data\Type\Inventory\ReleaseItemTransactionData::class, $out, $data),
			default => throw new \InvalidArgumentException("Unknown transaction data type")
		};
	}
}
