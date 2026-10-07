<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\NetworkInventoryAction;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use Nicholass003\Axiom\Enum\InventoryActionSourceType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class NetworkInventoryActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : NetworkInventoryAction{
		$raw = VarInt::readUnsignedInt($in);
		$sourceType = InventoryActionSourceType::safe($raw);
		if($sourceType === InventoryActionSourceType::UNKNOWN){
			throw new \RuntimeException("Unknown inventory action source type $raw");
		}

		$windowId = CodecHelper::readDoubleOptional($in, Byte::readSigned(...));
		$sourceFlags = CodecHelper::readDoubleOptional($in, VarInt::readUnsignedInt(...));

		return new NetworkInventoryAction(
			$sourceType,
			$windowId,
			$sourceFlags,
			inventorySlot: VarInt::readUnsignedInt($in),
			oldItem: $codec->read(ItemStackWrapper::class, $in),
			newItem: $codec->read(ItemStackWrapper::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof NetworkInventoryAction);

		if($data->sourceType === InventoryActionSourceType::UNKNOWN){
			throw new \InvalidArgumentException("Unknown inventory action source type");
		}
		VarInt::writeUnsignedInt($out, $data->sourceType->value);

		CodecHelper::writeDoubleOptional($out, $data->windowId, Byte::writeSigned(...));
		CodecHelper::writeDoubleOptional($out, $data->sourceFlags, VarInt::writeUnsignedInt(...));
		VarInt::writeUnsignedInt($out, $data->inventorySlot);
		$codec->write(ItemStackWrapper::class, $out, $data->oldItem);
		$codec->write(ItemStackWrapper::class, $out, $data->newItem);
	}
}
