<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\MemoryCategoryCounter;
use Nicholass003\Axiom\Enum\MemoryCategory;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class MemoryCategoryCounterSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MemoryCategoryCounter{
		return new MemoryCategoryCounter(
			category: MemoryCategory::safe(Byte::readUnsigned($in)),
			bytes: LE::readUnsignedLong($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MemoryCategoryCounter);

		Byte::writeUnsigned($out, $data->category->value);
		LE::writeUnsignedLong($out, $data->bytes);
	}
}