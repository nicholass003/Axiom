<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandEnumRawData;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandEnumSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, int $valueListSize = 0) : CommandEnumRawData{
		$name = CodecHelper::readString($in);
		$valueIndexes = CodecHelper::readList($in, fn($in) => match(true){
			$valueListSize < 256 => Byte::readUnsigned($in),
			$valueListSize < 65536 => LE::readUnsignedShort($in),
			default => LE::readUnsignedInt($in)
		});
		return new CommandEnumRawData(name: $name, valueIndexes: $valueIndexes);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec, int $valueListSize = 0) : void{
		assert($data instanceof CommandEnumRawData);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeList($out, $data->valueIndexes, fn($out, $index) => match(true){
			$valueListSize < 256 => Byte::writeUnsigned($out, $index),
			$valueListSize < 65536 => LE::writeUnsignedShort($out, $index),
			default => LE::writeUnsignedInt($out, $index)
		});
	}
}
