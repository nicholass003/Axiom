<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Camera;

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
 			blocks: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in)),
 			entities: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in)),
 			blockTags: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in)),
 			entityTypeFamilies: CodecHelper::readList($in, fn($in) => CodecHelper::readString($in))
 		);
 	}

 	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
 		assert($data instanceof CameraAimAssistPresetExclusionDefinition);

 		CodecHelper::writeList($out, $data->blocks, fn($out, $v) => CodecHelper::writeString($out, $v));
 		CodecHelper::writeList($out, $data->entities, fn($out, $v) => CodecHelper::writeString($out, $v));
 		CodecHelper::writeList($out, $data->blockTags, fn($out, $v) => CodecHelper::writeString($out, $v));
 		CodecHelper::writeList($out, $data->entityTypeFamilies, fn($out, $v) => CodecHelper::writeString($out, $v));
 	}
}
