<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\PlayerMovementSettingsData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class PlayerMovementSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PlayerMovementSettingsData{
		return new PlayerMovementSettingsData(
			rewindHistorySize: VarInt::readSignedInt($in),
			serverAuthoritativeBlockBreaking: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PlayerMovementSettingsData);

		VarInt::writeSignedInt($out, $data->rewindHistorySize);
		CodecHelper::writeBool($out, $data->serverAuthoritativeBlockBreaking);
	}
}
