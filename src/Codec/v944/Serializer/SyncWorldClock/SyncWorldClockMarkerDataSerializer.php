<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockMarkerData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class SyncWorldClockMarkerDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClockMarkerData{
		$id = VarInt::readUnsignedLong($in);
		$name = CodecHelper::readString($in);
		$time = VarInt::readSignedInt($in);
		$period = CodecHelper::readOptional($in, LE::readSignedInt(...));

		return new SyncWorldClockMarkerData(
			id: $id,
			name: $name,
			time: $time,
			period: $period
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClockMarkerData);

		VarInt::writeUnsignedLong($out, $data->id);
		CodecHelper::writeString($out, $data->name);
		VarInt::writeSignedInt($out, $data->time);
		CodecHelper::writeOptional($out, $data->period, LE::writeSignedInt(...));
	}
}
