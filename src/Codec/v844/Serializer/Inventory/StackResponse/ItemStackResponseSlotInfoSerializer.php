<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackResponse;

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
		return new ItemStackResponseSlotInfo(
			slot: Byte::readUnsigned($in),
			hotbarSlot: Byte::readUnsigned($in),
			count: Byte::readUnsigned($in),
			itemStackId: VarInt::readSignedInt($in),
			customName: CodecHelper::readString($in),
			filteredCustomName: CodecHelper::readString($in),
			durabilityCorrection: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackResponseSlotInfo);

		Byte::writeUnsigned($out, $data->slot);
		Byte::writeUnsigned($out, $data->hotbarSlot);
		Byte::writeUnsigned($out, $data->count);
		VarInt::writeSignedInt($out, $data->itemStackId);
		CodecHelper::writeString($out, $data->customName);
		CodecHelper::writeString($out, $data->filteredCustomName);
		VarInt::writeSignedInt($out, $data->durabilityCorrection);
	}
}
