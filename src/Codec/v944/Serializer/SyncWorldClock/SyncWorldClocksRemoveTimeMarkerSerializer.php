<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksRemoveTimeMarker;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClocksRemoveTimeMarkerSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClocksRemoveTimeMarker{
		$clockId = VarInt::readUnsignedLong($in);

		$markerIds = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$markerIds[] = VarInt::readUnsignedLong($in);
		}

		return new SyncWorldClocksRemoveTimeMarker(
			clockId: $clockId,
			markerIds: $markerIds
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClocksRemoveTimeMarker);

		VarInt::writeUnsignedLong($out, $data->clockId);

		VarInt::writeUnsignedInt($out, count($data->markerIds));
		foreach($data->markerIds as $markerId){
			VarInt::writeUnsignedLong($out, $markerId);
		}
	}
}
