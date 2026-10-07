<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraRotationOptionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraRotationOption{
		return new CameraRotationOption(
			value: CodecHelper::readVec3($in),
			time: LE::readFloat($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraRotationOption);

		CodecHelper::writeVec3($out, $data->value);
		LE::writeFloat($out, $data->time);
	}
}
