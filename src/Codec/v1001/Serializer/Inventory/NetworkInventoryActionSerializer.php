<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v1001\Serializer\Inventory;

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

		$windowId = null;
		$sourceFlags = 0;

		if(CodecHelper::readBool($in) && CodecHelper::readBool($in)){
			$windowId = Byte::readSigned($in);
		}
		if(CodecHelper::readBool($in) && CodecHelper::readBool($in)){
			$sourceFlags = VarInt::readUnsignedInt($in);
		}

		return new NetworkInventoryAction(
			$sourceType,
			$windowId,
			$sourceFlags,
			VarInt::readUnsignedInt($in),
			$codec->read(ItemStackWrapper::class, $in),
			$codec->read(ItemStackWrapper::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof NetworkInventoryAction);

		if($data->sourceType === InventoryActionSourceType::UNKNOWN){
			throw new \InvalidArgumentException("Unknown inventory action source type");
		}
		VarInt::writeUnsignedInt($out, $data->sourceType->value);

		CodecHelper::writeBool($out, true);
		if($data->sourceType === InventoryActionSourceType::CONTAINER || $data->sourceType === InventoryActionSourceType::TODO){
			CodecHelper::writeBool($out, true);
			Byte::writeSigned($out, $data->windowId ?? throw new \InvalidArgumentException("Window ID required for source type " . $data->sourceType->name));
		}else{
			CodecHelper::writeBool($out, false);
		}

		CodecHelper::writeBool($out, true);
		if($data->sourceType === InventoryActionSourceType::WORLD){
			CodecHelper::writeBool($out, true);
			VarInt::writeUnsignedInt($out, $data->sourceFlags);
		}else{
			CodecHelper::writeBool($out, false);
		}

		VarInt::writeUnsignedInt($out, $data->inventorySlot);
		$codec->write(ItemStackWrapper::class, $out, $data->oldItem);
		$codec->write(ItemStackWrapper::class, $out, $data->newItem);
	}
}
