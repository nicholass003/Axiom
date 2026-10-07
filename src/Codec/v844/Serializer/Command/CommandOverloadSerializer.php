<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandOverloadRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandParameterRawData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CommandOverloadSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandOverloadRawData{
		return new CommandOverloadRawData(
			chaining: CodecHelper::readBool($in),
			parameters: CodecHelper::readList($in, fn($in) => $codec->read(CommandParameterRawData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandOverloadRawData);

		CodecHelper::writeBool($out, $data->chaining);
		CodecHelper::writeList($out, $data->parameters, fn($out, $v) => $codec->write(CommandParameterRawData::class, $out, $v));
	}
}
