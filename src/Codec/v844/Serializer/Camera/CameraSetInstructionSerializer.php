<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstruction;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstructionEase;
use Nicholass003\Axiom\Data\Type\Camera\CameraSetInstructionRotation;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraSetInstructionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraSetInstruction{
		return new CameraSetInstruction(
			preset: LE::readUnsignedInt($in),
			ease: CodecHelper::readOptional($in, fn($i) => $codec->read(CameraSetInstructionEase::class, $i)),
			cameraPosition: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			rotation: CodecHelper::readOptional($in, fn($i) => $codec->read(CameraSetInstructionRotation::class, $i)),
			facingPosition: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			viewOffset: CodecHelper::readOptional($in, CodecHelper::readVec2(...)),
			entityOffset: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			default: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
			ignoreStartingValuesComponent: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraSetInstruction);

		LE::writeUnsignedInt($out, $data->preset);
		CodecHelper::writeOptional($out, $data->ease, fn($o, $v) => $codec->write(CameraSetInstructionEase::class, $o, $v));
		CodecHelper::writeOptional($out, $data->cameraPosition, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->rotation, fn($o, $v) => $codec->write(CameraSetInstructionRotation::class, $o, $v));
		CodecHelper::writeOptional($out, $data->facingPosition, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->viewOffset, fn($o, $v) => CodecHelper::writeVec2($o, $v));
		CodecHelper::writeOptional($out, $data->entityOffset, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->default, fn($o, $v) => CodecHelper::writeBool($o, $v));
		CodecHelper::writeBool($out, $data->ignoreStartingValuesComponent);
	}
}
