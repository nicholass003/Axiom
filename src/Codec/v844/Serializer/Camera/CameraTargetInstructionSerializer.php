<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraTargetInstruction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CameraTargetInstructionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraTargetInstruction{
		return new CameraTargetInstruction(
			targetCenterOffset: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			actorUniqueId: VarInt::readSignedLong($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraTargetInstruction);

		CodecHelper::writeOptional($out, $data->targetCenterOffset, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		VarInt::writeSignedLong($out, $data->actorUniqueId);
	}
}
