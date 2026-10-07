<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\NoiseAlignment;
use Nicholass003\Axiom\Enum\NoiseAlignmentType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class NoiseAlignmentSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : NoiseAlignment{
		return new NoiseAlignment(
			type: NoiseAlignmentType::fromPacket(Byte::readUnsigned($in)),
			value: VarInt::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof NoiseAlignment);

		Byte::writeUnsigned($out, $data->type->toPacket());
		VarInt::writeUnsignedInt($out, $data->value);
	}
}
