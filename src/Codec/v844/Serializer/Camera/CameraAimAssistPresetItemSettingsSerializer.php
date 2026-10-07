<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistPresetItemSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CameraAimAssistPresetItemSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistPresetItemSettings{
		return new CameraAimAssistPresetItemSettings(
			itemIdentifier: CodecHelper::readString($in),
			categoryName: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistPresetItemSettings);

		CodecHelper::writeString($out, $data->itemIdentifier);
		CodecHelper::writeString($out, $data->categoryName);
	}
}
