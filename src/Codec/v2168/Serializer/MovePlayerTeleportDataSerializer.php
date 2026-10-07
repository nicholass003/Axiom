<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\MovePlayerTeleportData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class MovePlayerTeleportDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MovePlayerTeleportData{
		return new MovePlayerTeleportData(
			cause: LE::readUnsignedInt($in),
			sourceActorType: LE::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MovePlayerTeleportData);

		LE::writeUnsignedInt($out, $data->cause);
		LE::writeUnsignedInt($out, $data->sourceActorType);
	}
}
