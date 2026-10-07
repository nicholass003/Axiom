<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class FullContainerNameSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : FullContainerName{
		return new FullContainerName(
			containerId: Byte::readUnsigned($in),
			dynamicId: CodecHelper::readOptional($in, LE::readUnsignedInt(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof FullContainerName);

		Byte::writeUnsigned($out, $data->containerId);
		CodecHelper::writeOptional($out, $data->dynamicId, LE::writeUnsignedInt(...));
	}
}
