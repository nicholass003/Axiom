<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockStateData;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksSyncState;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClocksSyncStateSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClocksSyncState{
		$states = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$states[] = $codec->read(SyncWorldClockStateData::class, $in);
		}

		return new SyncWorldClocksSyncState(
			states: $states
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClocksSyncState);

		VarInt::writeUnsignedInt($out, count($data->states));
		foreach($data->states as $state){
			$codec->write(SyncWorldClockStateData::class, $out, $state);
		}
	}
}
