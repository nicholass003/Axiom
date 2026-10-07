<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandOutputMessage;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CommandOutputMessageSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandOutputMessage{
		return new CommandOutputMessage(
			isInternal: CodecHelper::readBool($in),
			messageId: CodecHelper::readString($in),
			parameters: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandOutputMessage);

		CodecHelper::writeBool($out, $data->isInternal);
		CodecHelper::writeString($out, $data->messageId);
		CodecHelper::writeList($out, $data->parameters, fn($out, $p) => CodecHelper::writeString($out, $p));
	}
}
