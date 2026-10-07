<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CreativeCreateStackRequestAction;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CreativeCreateStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CreativeCreateStackRequestAction{
		return new CreativeCreateStackRequestAction(
			creativeItemId: CodecHelper::readCreativeItemNetId($in),
			repetitions: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CreativeCreateStackRequestAction);

		CodecHelper::writeCreativeItemNetId($out, $data->creativeItemId);
		Byte::writeUnsigned($out, $data->repetitions);
	}
}
