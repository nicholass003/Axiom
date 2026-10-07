<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPosition;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SubChunkPositionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SubChunkPosition{
		return new SubChunkPosition(
			x: VarInt::readSignedInt($in),
			y: VarInt::readSignedInt($in),
			z: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SubChunkPosition);

		VarInt::writeSignedInt($out, $data->x);
		VarInt::writeSignedInt($out, $data->y);
		VarInt::writeSignedInt($out, $data->z);
	}
}
