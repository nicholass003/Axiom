<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeGroupEntry;
use Nicholass003\Axiom\Data\Type\ItemStack;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CreativeGroupEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CreativeGroupEntry{
		return new CreativeGroupEntry(
			categoryId: Byte::readUnsigned($in),
			categoryName: CodecHelper::readString($in),
			icon: $codec->read(ItemStack::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CreativeGroupEntry);

		Byte::writeUnsigned($out, $data->categoryId);
		CodecHelper::writeString($out, $data->categoryName);
		$codec->write(ItemStack::class, $out, $data->icon);
	}
}
