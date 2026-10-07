<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\Inventory\StackResponse;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseSlotInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ItemStackResponseSlotInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackResponseSlotInfo{
		$slot = Byte::readUnsigned($in);
		$hotbarSlot = Byte::readUnsigned($in);
		$count = Byte::readUnsigned($in);
		$itemStackId = CodecHelper::readOptional($in, CodecHelper::readServerItemStackId(...));
		$customName = CodecHelper::readString($in);
		$filteredCustomName = CodecHelper::readOptional($in, CodecHelper::readString(...));
		$durabilityCorrection = VarInt::readSignedInt($in);

		return new ItemStackResponseSlotInfo(
			$slot,
			$hotbarSlot,
			$count,
			$itemStackId,
			$customName,
			$filteredCustomName,
			$durabilityCorrection
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackResponseSlotInfo);

		Byte::writeUnsigned($out, $data->slot);
		Byte::writeUnsigned($out, $data->hotbarSlot);
		Byte::writeUnsigned($out, $data->count);
		CodecHelper::writeOptional($out, $data->itemStackId, CodecHelper::writeServerItemStackId(...));
		CodecHelper::writeString($out, $data->customName);
		CodecHelper::writeOptional($out, $data->filteredCustomName, CodecHelper::writeString(...));
		VarInt::writeSignedInt($out, $data->durabilityCorrection);
	}
}