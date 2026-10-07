<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Trim;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Trim\TrimPattern;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class TrimPatternSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : TrimPattern{
		return new TrimPattern(
			itemId: CodecHelper::readString($in),
			patternId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof TrimPattern);

		CodecHelper::writeString($out, $data->itemId);
		CodecHelper::writeString($out, $data->patternId);
	}
}
