<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistActorPriority;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraAimAssistActorPrioritySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistActorPriority{
		return new CameraAimAssistActorPriority(
			presetIndex: LE::readSignedInt($in),
			categoryIndex: LE::readSignedInt($in),
			actorIndex: LE::readSignedInt($in),
			priority: LE::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistActorPriority);

		LE::writeSignedInt($out, $data->presetIndex);
		LE::writeSignedInt($out, $data->categoryIndex);
		LE::writeSignedInt($out, $data->actorIndex);
		LE::writeSignedInt($out, $data->priority);
	}
}