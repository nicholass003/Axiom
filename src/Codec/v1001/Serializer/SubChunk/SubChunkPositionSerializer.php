<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v1001\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPosition;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class SubChunkPositionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, bool $fixedInts = false) : SubChunkPosition{
		if($fixedInts){
			return new SubChunkPosition(
				x: LE::readSignedInt($in),
				y: LE::readSignedInt($in),
				z: LE::readSignedInt($in)
			);
		}

		return new SubChunkPosition(
			x: VarInt::readSignedInt($in),
			y: VarInt::readSignedInt($in),
			z: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, bool $fixedInts = false) : void{
		assert($data instanceof SubChunkPosition);

		if($fixedInts){
			LE::writeSignedInt($out, $data->x);
			LE::writeSignedInt($out, $data->y);
			LE::writeSignedInt($out, $data->z);
			return;
		}

		VarInt::writeSignedInt($out, $data->x);
		VarInt::writeSignedInt($out, $data->y);
		VarInt::writeSignedInt($out, $data->z);
	}
}
