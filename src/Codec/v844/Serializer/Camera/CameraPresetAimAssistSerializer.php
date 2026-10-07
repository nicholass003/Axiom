<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraPresetAimAssist;
use Nicholass003\Axiom\Enum\CameraAimAssistTargetMode;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraPresetAimAssistSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraPresetAimAssist{
		return new CameraPresetAimAssist(
			presetId: CodecHelper::readOptional($in, CodecHelper::readString(...)),
			targetMode: CodecHelper::readOptional($in, fn($i) => CameraAimAssistTargetMode::safe(Byte::readUnsigned($i))),
			viewAngle: CodecHelper::readOptional($in, CodecHelper::readVec2(...)),
			distance: CodecHelper::readOptional($in, LE::readFloat(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraPresetAimAssist);

		CodecHelper::writeOptional($out, $data->presetId, CodecHelper::writeString(...));
		CodecHelper::writeOptional($out, $data->targetMode, fn($o, $v) => Byte::writeUnsigned($o, $v->value));
		CodecHelper::writeOptional($out, $data->viewAngle, fn($o, $v) => CodecHelper::writeVec2($o, $v));
		CodecHelper::writeOptional($out, $data->distance, fn($o, $v) => LE::writeFloat($o, $v));
	}
}
