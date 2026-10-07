<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumRawData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandEnumSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandEnumRawData{
		return new CommandEnumRawData(
			name: CodecHelper::readString($in),
			valueIndexes: CodecHelper::readList($in, fn($in) => LE::readUnsignedInt($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandEnumRawData);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeList($out, $data->valueIndexes, fn($out, $index) => LE::writeUnsignedInt($out, $index));
	}
}
