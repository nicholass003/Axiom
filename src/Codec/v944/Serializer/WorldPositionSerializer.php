<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\WorldPosition;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class WorldPositionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : WorldPosition{
		return CodecHelper::readWorldPosition($in);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof WorldPosition);

		CodecHelper::writeWorldPosition($out, $data);
	}
}
