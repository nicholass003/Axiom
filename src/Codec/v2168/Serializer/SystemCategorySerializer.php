<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SystemCategory;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class SystemCategorySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SystemCategory{
		return new SystemCategory(
			categoryName: CodecHelper::readString($in),
			systemIndex: LE::readUnsignedLong($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SystemCategory);

		CodecHelper::writeString($out, $data->categoryName);
		LE::writeUnsignedLong($out, $data->systemIndex);
	}
}
