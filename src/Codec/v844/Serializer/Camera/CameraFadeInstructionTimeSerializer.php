<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionTime;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraFadeInstructionTimeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraFadeInstructionTime{
		return new CameraFadeInstructionTime(
			fadeInTime: LE::readFloat($in),
			stayTime: LE::readFloat($in),
			fadeOutTime: LE::readFloat($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraFadeInstructionTime);

		LE::writeFloat($out, $data->fadeInTime);
		LE::writeFloat($out, $data->stayTime);
		LE::writeFloat($out, $data->fadeOutTime);
	}
}
