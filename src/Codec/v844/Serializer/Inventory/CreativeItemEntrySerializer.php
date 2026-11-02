<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeItemEntry;
use Nicholass003\Axiom\Data\Type\ItemStack;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CreativeItemEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CreativeItemEntry{
		return new CreativeItemEntry(
			entryId: CodecHelper::readCreativeItemNetId($in),
			item: $codec->read(ItemStack::class, $in),
			groupId: VarInt::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CreativeItemEntry);

		CodecHelper::writeCreativeItemNetId($out, $data->entryId);
		$codec->write(ItemStack::class, $out, $data->item);
		VarInt::writeUnsignedInt($out, $data->groupId);
	}
}
