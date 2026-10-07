<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumConstraintRawData;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandEnumConstraintSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandEnumConstraintRawData{
		return new CommandEnumConstraintRawData(
			affectedValueIndex: LE::readUnsignedInt($in),
			enumIndex: LE::readUnsignedInt($in),
			constraints: CodecHelper::readList($in, Byte::readUnsigned(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandEnumConstraintRawData);

		LE::writeUnsignedInt($out, $data->affectedValueIndex);
		LE::writeUnsignedInt($out, $data->enumIndex);
		CodecHelper::writeList($out, $data->constraints, fn($out, $v) => Byte::writeUnsigned($out, $v));
	}
}
