<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockStateData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClockStateDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClockStateData{
		$clockId = VarInt::readUnsignedLong($in);
		$time = VarInt::readSignedInt($in);
		$paused = CodecHelper::readBool($in);

		return new SyncWorldClockStateData(
			clockId: $clockId,
			time: $time,
			paused: $paused
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClockStateData);

		VarInt::writeUnsignedLong($out, $data->clockId);
		VarInt::writeSignedInt($out, $data->time);
		CodecHelper::writeBool($out, $data->paused);
	}
}
