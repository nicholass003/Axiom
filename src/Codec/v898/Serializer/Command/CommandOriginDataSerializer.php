<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Enum\CommandOriginType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandOriginDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandOriginData{
		return new CommandOriginData(
			type: CommandOriginType::fromString(CodecHelper::readString($in)),
			uuid: CodecHelper::readUuid($in),
			requestId: CodecHelper::readString($in),
			playerActorUniqueId: LE::readSignedLong($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandOriginData);

		CodecHelper::writeString($out, $data->type->toString());
		CodecHelper::writeUuid($out, $data->uuid);
		CodecHelper::writeString($out, $data->requestId);
		LE::writeSignedLong($out, $data->playerActorUniqueId);
	}
}
