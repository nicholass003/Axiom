<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraFovInstruction;
use Nicholass003\Axiom\Enum\CameraSetInstructionEaseType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraFovInstructionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraFovInstruction{
		return new CameraFovInstruction(
			fieldOfView: LE::readFloat($in),
			easeTime: LE::readFloat($in),
			easeType: CameraSetInstructionEaseType::fromString(CodecHelper::readString($in)),
			clear: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraFovInstruction);

		LE::writeFloat($out, $data->fieldOfView);
		LE::writeFloat($out, $data->easeTime);
		CodecHelper::writeString($out, $data->easeType->toString());
		CodecHelper::writeBool($out, $data->clear);
	}
}
