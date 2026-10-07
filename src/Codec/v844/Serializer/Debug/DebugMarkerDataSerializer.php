<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Debug;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Debug\DebugMarkerData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class DebugMarkerDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DebugMarkerData{
		return new DebugMarkerData(
			text: CodecHelper::readString($in),
			position: CodecHelper::readVec3($in),
			color: LE::readUnsignedInt($in),
			durationMillis: VarInt::readSignedLong($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DebugMarkerData);

		CodecHelper::writeString($out, $data->text);
		CodecHelper::writeVec3($out, $data->position);
		LE::writeUnsignedInt($out, $data->color);
		VarInt::writeSignedLong($out, $data->durationMillis);
	}
}
