<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPositionOffset;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SubChunkPositionOffsetSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SubChunkPositionOffset{
		return new SubChunkPositionOffset(
			xOffset: VarInt::readSignedInt($in),
			yOffset: VarInt::readSignedInt($in),
			zOffset: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SubChunkPositionOffset);

		VarInt::writeSignedInt($out, $data->xOffset);
		VarInt::writeSignedInt($out, $data->yOffset);
		VarInt::writeSignedInt($out, $data->zOffset);
	}
}
