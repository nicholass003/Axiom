<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryPriority;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraAimAssistCategoryPrioritySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistCategoryPriority{
		return new CameraAimAssistCategoryPriority(
			identifier: CodecHelper::readString($in),
			priority: LE::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistCategoryPriority);

		CodecHelper::writeString($out, $data->identifier);
		LE::writeSignedInt($out, $data->priority);
	}
}
