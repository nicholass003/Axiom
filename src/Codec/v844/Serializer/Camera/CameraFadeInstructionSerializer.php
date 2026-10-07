<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionColor;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionTime;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraFadeInstructionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraFadeInstruction{
		return new CameraFadeInstruction(
			time: CodecHelper::readOptional($in, fn($i) => $codec->read(CameraFadeInstructionTime::class, $i)),
			color: CodecHelper::readOptional($in, fn($i) => $codec->read(CameraFadeInstructionColor::class, $i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraFadeInstruction);

		CodecHelper::writeOptional($out, $data->time, fn($o, $v) => $codec->write(CameraFadeInstructionTime::class, $o, $v));
		CodecHelper::writeOptional($out, $data->color, fn($o, $v) => $codec->write(CameraFadeInstructionColor::class, $o, $v));
	}
}
