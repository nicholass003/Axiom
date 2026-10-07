<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandParameterRawData;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandParameterSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandParameterRawData{
		return new CommandParameterRawData(
			name: CodecHelper::readString($in),
			typeInfo: LE::readUnsignedInt($in),
			optional: CodecHelper::readBool($in),
			flags: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandParameterRawData);

		CodecHelper::writeString($out, $data->name);
		LE::writeUnsignedInt($out, $data->typeInfo);
		CodecHelper::writeBool($out, $data->optional);
		Byte::writeUnsigned($out, $data->flags);
	}
}
