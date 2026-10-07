<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryBlockPriority;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryEntityPriority;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class CameraAimAssistCategorySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistCategory{
		$name = CodecHelper::readString($in);
		$entities = [];
		$entityCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $entityCount; $i++){
			$entities[] = $codec->read(CameraAimAssistCategoryEntityPriority::class, $in);
		}

		$blocks = [];
		$blockCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $blockCount; $i++){
			$blocks[] = $codec->read(CameraAimAssistCategoryBlockPriority::class, $in);
		}

		$defaultEntityPriority = CodecHelper::readOptional($in, fn($i) => LE::readSignedInt($i));
		$defaultBlockPriority = CodecHelper::readOptional($in, fn($i) => LE::readSignedInt($i));

		return new CameraAimAssistCategory(
			name: $name,
			entities: $entities,
			blocks: $blocks,
			defaultEntityPriority: $defaultEntityPriority,
			defaultBlockPriority: $defaultBlockPriority
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistCategory);

		CodecHelper::writeString($out, $data->name);
		VarInt::writeUnsignedInt($out, count($data->entities));
		foreach($data->entities as $e){
			$codec->write(CameraAimAssistCategoryEntityPriority::class, $out, $e);
		}

		VarInt::writeUnsignedInt($out, count($data->blocks));
		foreach($data->blocks as $b){
			$codec->write(CameraAimAssistCategoryBlockPriority::class, $out, $b);
		}

		CodecHelper::writeOptional($out, $data->defaultEntityPriority, fn($o, $v) => LE::writeSignedInt($o, $v));
		CodecHelper::writeOptional($out, $data->defaultBlockPriority, fn($o, $v) => LE::writeSignedInt($o, $v));
	}
}
