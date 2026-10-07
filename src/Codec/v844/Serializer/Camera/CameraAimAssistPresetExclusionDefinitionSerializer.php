<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetExclusionDefinition;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraAimAssistPresetExclusionDefinitionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistPresetExclusionDefinition{
		return new CameraAimAssistPresetExclusionDefinition(
			blocks: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistPresetExclusionDefinition);

		CodecHelper::writeList($out, $data->blocks, fn($o, $v) => CodecHelper::writeString($o, $v));
	}
}
