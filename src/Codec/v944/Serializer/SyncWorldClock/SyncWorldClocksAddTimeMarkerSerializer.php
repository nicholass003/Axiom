<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockMarkerData;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksAddTimeMarker;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClocksAddTimeMarkerSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClocksAddTimeMarker{
		$clockId = VarInt::readUnsignedLong($in);

		$markers = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$markers[] = $codec->read(SyncWorldClockMarkerData::class, $in);
		}

		return new SyncWorldClocksAddTimeMarker(
			clockId: $clockId,
			markers: $markers
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClocksAddTimeMarker);

		VarInt::writeUnsignedLong($out, $data->clockId);

		VarInt::writeUnsignedInt($out, count($data->markers));
		foreach($data->markers as $marker){
			$codec->write(SyncWorldClockMarkerData::class, $out, $marker);
		}
	}
}
