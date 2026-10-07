<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPreset;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetExclusionDefinition;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetItemSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraAimAssistPresetSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistPreset{
		return new CameraAimAssistPreset(
			identifier: CodecHelper::readString($in),
			exclusionList: $codec->read(CameraAimAssistPresetExclusionDefinition::class, $in),
			liquidTargetingList: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in)),
			itemSettings: CodecHelper::readList($in, fn($in) => $codec->read(CameraAimAssistPresetItemSettings::class, $in)),
			defaultItemSettings: CodecHelper::readOptional($in, CodecHelper::readString(...)),
			defaultHandSettings: CodecHelper::readOptional($in, CodecHelper::readString(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistPreset);

		CodecHelper::writeString($out, $data->identifier);
		$codec->write(CameraAimAssistPresetExclusionDefinition::class, $out, $data->exclusionList);
		CodecHelper::writeList($out, $data->liquidTargetingList, fn($out, $v) => CodecHelper::writeString($out, $v));
		CodecHelper::writeList($out, $data->itemSettings, fn($out, $v) => $codec->write(CameraAimAssistPresetItemSettings::class, $out, $v));
		CodecHelper::writeOptional($out, $data->defaultItemSettings, CodecHelper::writeString(...));
		CodecHelper::writeOptional($out, $data->defaultHandSettings, CodecHelper::writeString(...));
	}
}
