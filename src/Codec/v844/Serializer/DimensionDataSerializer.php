<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DimensionData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class DimensionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DimensionData{
		return new DimensionData(
			maxHeight: VarInt::readSignedInt($in),
			minHeight: VarInt::readSignedInt($in),
			generator: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DimensionData);

		VarInt::writeSignedInt($out, $data->maxHeight);
		VarInt::writeSignedInt($out, $data->minHeight);
		VarInt::writeSignedInt($out, $data->generator);
	}
}
