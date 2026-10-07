<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

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
			messageId: CodecHelper::readString($in),
			isInternal: CodecHelper::readBool($in),
			parameters: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandOutputMessage);

		CodecHelper::writeString($out, $data->messageId);
		CodecHelper::writeBool($out, $data->isInternal);
		CodecHelper::writeList($out, $data->parameters, fn($out, $p) => CodecHelper::writeString($out, $p));
	}
}
