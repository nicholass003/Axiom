<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockData;
use Nicholass003\Axiom\Data\Type\SyncWorldClockMarkerData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClockDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClockData{
		$id = VarInt::readUnsignedLong($in);
		$name = CodecHelper::readString($in);
		$time = VarInt::readSignedInt($in);
		$paused = CodecHelper::readBool($in);

		$markers = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$markers[] = $codec->read(SyncWorldClockMarkerData::class, $in);
		}

		return new SyncWorldClockData(
			id: $id,
			name: $name,
			time: $time,
			paused: $paused,
			markers: $markers
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClockData);

		VarInt::writeUnsignedLong($out, $data->id);
		CodecHelper::writeString($out, $data->name);
		VarInt::writeSignedInt($out, $data->time);
		CodecHelper::writeBool($out, $data->paused);

		VarInt::writeUnsignedInt($out, count($data->markers));
		foreach($data->markers as $marker){
			$codec->write(SyncWorldClockMarkerData::class, $out, $marker);
		}
	}
}
