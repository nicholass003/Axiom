<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandValueRawData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ChainedSubCommandValueSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ChainedSubCommandValueRawData{
		return new ChainedSubCommandValueRawData(
			nameIndex: VarInt::readUnsignedInt($in),
			type: VarInt::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ChainedSubCommandValueRawData);

		VarInt::writeUnsignedInt($out, $data->nameIndex);
		VarInt::writeUnsignedInt($out, $data->type);
	}
}
