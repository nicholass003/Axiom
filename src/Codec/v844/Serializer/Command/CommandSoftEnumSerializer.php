<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandSoftEnum;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CommandSoftEnumSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandSoftEnum{
		return new CommandSoftEnum(
			name: CodecHelper::readString($in),
			values: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandSoftEnum);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeList($out, $data->values, fn($out, $v) => CodecHelper::writeString($out, $v));
	}
}
