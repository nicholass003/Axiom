<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\CreativeGroupEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CreativeGroupEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CreativeGroupEntry{
		return new CreativeGroupEntry(
			categoryId: LE::readSignedInt($in),
			categoryName: CodecHelper::readString($in),
			icon: CodecHelper::readItemStackWithoutStackId($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CreativeGroupEntry);

		LE::writeSignedInt($out, $data->categoryId);
		CodecHelper::writeString($out, $data->categoryName);
		CodecHelper::writeItemStackWithoutStackId($out, $data->icon);
	}
}
