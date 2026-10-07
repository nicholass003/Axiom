<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraSplineInstructionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraSplineInstruction{
		return new CameraSplineInstruction(
			totalTime: LE::readFloat($in),
			easeType: LE::readUnsignedInt($in),
			curve: CodecHelper::readList($in, CodecHelper::readVec3(...)),
			progressKeyFrames: CodecHelper::readList($in, fn($in) => $codec->read(CameraProgressOption::class, $in)),
			rotationOptions: CodecHelper::readList($in, fn($in) => $codec->read(CameraRotationOption::class, $in)),
			splineIdentifier: CodecHelper::readString($in),
			loadFromJson: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraSplineInstruction);

		LE::writeFloat($out, $data->totalTime);
		LE::writeUnsignedInt($out, $data->easeType);
		CodecHelper::writeList($out, $data->curve, fn($out, $v) => CodecHelper::writeVec3($out, $v));
		CodecHelper::writeList($out, $data->progressKeyFrames, fn($out, $v) => $codec->write(CameraProgressOption::class, $out, $v));
		CodecHelper::writeList($out, $data->rotationOptions, fn($out, $v) => $codec->write(CameraRotationOption::class, $out, $v));
		CodecHelper::writeString($out, $data->splineIdentifier);
		CodecHelper::writeBool($out, $data->loadFromJson);
	}
}
