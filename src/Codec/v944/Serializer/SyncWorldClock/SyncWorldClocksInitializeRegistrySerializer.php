<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\SyncWorldClock;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SyncWorldClockData;
use Nicholass003\Axiom\Data\Type\SyncWorldClocksInitializeRegistry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SyncWorldClocksInitializeRegistrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SyncWorldClocksInitializeRegistry{
		$clockData = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$clockData[] = $codec->read(SyncWorldClockData::class, $in);
		}

		return new SyncWorldClocksInitializeRegistry(
			clocks: $clockData
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SyncWorldClocksInitializeRegistry);

		VarInt::writeUnsignedInt($out, count($data->clocks));
		foreach($data->clocks as $clock){
			$codec->write(SyncWorldClockData::class, $out, $clock);
		}
	}
}
