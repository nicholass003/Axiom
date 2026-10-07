<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandValueRawData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ChainedSubCommandValueSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ChainedSubCommandValueRawData{
		return new ChainedSubCommandValueRawData(
			nameIndex: LE::readUnsignedShort($in),
			type: LE::readUnsignedShort($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ChainedSubCommandValueRawData);

		LE::writeUnsignedShort($out, $data->nameIndex);
		LE::writeUnsignedShort($out, $data->type);
	}
}
