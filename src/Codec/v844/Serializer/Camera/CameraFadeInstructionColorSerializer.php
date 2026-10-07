<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraFadeInstructionColor;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraFadeInstructionColorSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraFadeInstructionColor{
		return new CameraFadeInstructionColor(
			red: LE::readFloat($in),
			green: LE::readFloat($in),
			blue: LE::readFloat($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraFadeInstructionColor);

		LE::writeFloat($out, $data->red);
		LE::writeFloat($out, $data->green);
		LE::writeFloat($out, $data->blue);
	}
}
