<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ChunkCacheBlob;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ChunkCacheBlobSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ChunkCacheBlob{
		return new ChunkCacheBlob(
			hash: LE::readUnsignedLong($in),
			payload: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ChunkCacheBlob);

		LE::writeUnsignedLong($out, $data->hash);
		CodecHelper::writeString($out, $data->payload);
	}
}
