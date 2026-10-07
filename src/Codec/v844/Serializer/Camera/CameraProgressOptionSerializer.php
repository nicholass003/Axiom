<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Enum\CameraSetInstructionEaseType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraProgressOptionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraProgressOption{
		return new CameraProgressOption(
			value: LE::readFloat($in),
			time: LE::readFloat($in),
			easeType: CameraSetInstructionEaseType::safe(Byte::readUnsigned($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraProgressOption);

		LE::writeFloat($out, $data->value);
		LE::writeFloat($out, $data->time);
		Byte::writeUnsigned($out, $data->easeType->value);
	}
}
