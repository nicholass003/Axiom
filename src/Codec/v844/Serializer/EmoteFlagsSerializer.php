<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\EmoteFlags;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EmoteFlagsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : EmoteFlags{
        return EmoteFlags::fromInt(Byte::readUnsigned($in));
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof EmoteFlags);
        Byte::writeUnsigned($out, $data->toInt());
	}
}
