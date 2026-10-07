<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraPreset;
use Nicholass003\Axiom\Data\Type\Camera\CameraPresetAimAssist;
use Nicholass003\Axiom\Enum\ControlScheme;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CameraPresetSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraPreset{
		return new CameraPreset(
			name: CodecHelper::readString($in),
			parent: CodecHelper::readString($in),
			xPosition: CodecHelper::readOptional($in, LE::readFloat(...)),
			yPosition: CodecHelper::readOptional($in, LE::readFloat(...)),
			zPosition: CodecHelper::readOptional($in, LE::readFloat(...)),
			pitch: CodecHelper::readOptional($in, LE::readFloat(...)),
			yaw: CodecHelper::readOptional($in, LE::readFloat(...)),
			rotationSpeed: CodecHelper::readOptional($in, LE::readFloat(...)),
			snapToTarget: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
			horizontalRotationLimit: CodecHelper::readOptional($in, CodecHelper::readVec2(...)),
			verticalRotationLimit: CodecHelper::readOptional($in, CodecHelper::readVec2(...)),
			continueTargeting: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
			blockListeningRadius: CodecHelper::readOptional($in, LE::readFloat(...)),
			viewOffset: CodecHelper::readOptional($in, CodecHelper::readVec2(...)),
			entityOffset: CodecHelper::readOptional($in, CodecHelper::readVec3(...)),
			radius: CodecHelper::readOptional($in, LE::readFloat(...)),
			yawLimitMin: CodecHelper::readOptional($in, LE::readFloat(...)),
			yawLimitMax: CodecHelper::readOptional($in, LE::readFloat(...)),
			audioListenerType: CodecHelper::readOptional($in, Byte::readUnsigned(...)),
			playerEffects: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
			aimAssist: CodecHelper::readOptional($in, fn($i) => $codec->read(CameraPresetAimAssist::class, $i)),
			controlScheme: CodecHelper::readOptional($in, fn($i) => ControlScheme::safe(Byte::readUnsigned($i))),
			applyInheritedStartingRotation: CodecHelper::readBool($in),
			startingRotation: CodecHelper::readOptional($in, CodecHelper::readVec2(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraPreset);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeString($out, $data->parent);
		CodecHelper::writeOptional($out, $data->xPosition, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->yPosition, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->zPosition, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->pitch, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->yaw, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->rotationSpeed, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->snapToTarget, fn($o, $v) => CodecHelper::writeBool($o, $v));
		CodecHelper::writeOptional($out, $data->horizontalRotationLimit, fn($o, $v) => CodecHelper::writeVec2($o, $v));
		CodecHelper::writeOptional($out, $data->verticalRotationLimit, fn($o, $v) => CodecHelper::writeVec2($o, $v));
		CodecHelper::writeOptional($out, $data->continueTargeting, fn($o, $v) => CodecHelper::writeBool($o, $v));
		CodecHelper::writeOptional($out, $data->blockListeningRadius, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->viewOffset, fn($o, $v) => CodecHelper::writeVec2($o, $v));
		CodecHelper::writeOptional($out, $data->entityOffset, fn($o, $v) => CodecHelper::writeVec3($o, $v));
		CodecHelper::writeOptional($out, $data->radius, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->yawLimitMin, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->yawLimitMax, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeOptional($out, $data->audioListenerType, fn($o, $v) => Byte::writeUnsigned($o, $v));
		CodecHelper::writeOptional($out, $data->playerEffects, fn($o, $v) => CodecHelper::writeBool($o, $v));
		CodecHelper::writeOptional($out, $data->aimAssist, fn($o, $v) => $codec->write(CameraPresetAimAssist::class, $o, $v));
		CodecHelper::writeOptional($out, $data->controlScheme, fn($o, $v) => Byte::writeUnsigned($o, $v->value));
		CodecHelper::writeBool($out, $data->applyInheritedStartingRotation);
		CodecHelper::writeOptional($out, $data->startingRotation, fn($o, $v) => CodecHelper::writeVec2($o, $v));
	}
}
