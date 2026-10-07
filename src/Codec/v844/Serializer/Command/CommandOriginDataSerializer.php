<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandOriginData;
use Nicholass003\Axiom\Enum\CommandOriginType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CommandOriginDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandOriginData{
		$type = CommandOriginType::safe(VarInt::readUnsignedInt($in));
		$uuid = CodecHelper::readUuid($in);
		$requestId = CodecHelper::readString($in);

		$playerActorUniqueId = 0;
		if($type === CommandOriginType::DEV_CONSOLE || $type === CommandOriginType::TEST){
			$playerActorUniqueId = VarInt::readSignedLong($in);
		}

		return new CommandOriginData(
			type: $type,
			uuid: $uuid,
			requestId: $requestId,
			playerActorUniqueId: $playerActorUniqueId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandOriginData);

		VarInt::writeUnsignedInt($out, $data->type->value);
		CodecHelper::writeUuid($out, $data->uuid);
		CodecHelper::writeString($out, $data->requestId);

		if($data->type === CommandOriginType::DEV_CONSOLE || $data->type === CommandOriginType::TEST){
			VarInt::writeSignedLong($out, $data->playerActorUniqueId);
		}
	}
}
