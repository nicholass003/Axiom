<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Camera;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategory;
use Nicholass003\Axiom\Data\Type\Camera\CameraAimAssistCategoryPriority;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class CameraAimAssistCategorySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CameraAimAssistCategory{
		$entities = [];
		$entityCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $entityCount; ++$i){
			$entities[] = $codec->read(CameraAimAssistCategoryPriority::class, $in);
		}

		$blocks = [];
		$blockCount = VarInt::readUnsignedInt($in);
		for($i = 0; $i < $blockCount; ++$i){
			$blocks[] = $codec->read(CameraAimAssistCategoryPriority::class, $in);
		}

		$blockTags = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$blockTags[] = $codec->read(CameraAimAssistCategoryPriority::class, $in);
		}

		$entityTypeFamilies = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$entityTypeFamilies[] = $codec->read(CameraAimAssistCategoryPriority::class, $in);
		}

		$defaultEntity = CodecHelper::readOptional($in, fn($i) => LE::readSignedInt($i));
		$defaultBlock = CodecHelper::readOptional($in, fn($i) => LE::readSignedInt($i));
		$name = CodecHelper::readString($in);

		return new CameraAimAssistCategory(
			name: $name,
			entities: $entities,
			blocks: $blocks,
			blockTags: $blockTags,
			entityTypeFamilies: $entityTypeFamilies,
			defaultEntityPriority: $defaultEntity,
			defaultBlockPriority: $defaultBlock
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CameraAimAssistCategory);

		VarInt::writeUnsignedInt($out, count($data->entities));
		foreach($data->entities as $e){
			$codec->write(CameraAimAssistCategoryPriority::class, $out, $e);
		}

		VarInt::writeUnsignedInt($out, count($data->blocks));
		foreach($data->blocks as $b){
			$codec->write(CameraAimAssistCategoryPriority::class, $out, $b);
		}

		VarInt::writeUnsignedInt($out, count($data->blockTags));
		foreach($data->blockTags as $tag){
			$codec->write(CameraAimAssistCategoryPriority::class, $out, $tag);
		}

		VarInt::writeUnsignedInt($out, count($data->entityTypeFamilies));
		foreach($data->entityTypeFamilies as $family){
			$codec->write(CameraAimAssistCategoryPriority::class, $out, $family);
		}

		CodecHelper::writeOptional($out, $data->defaultEntityPriority, fn($o, $v) => LE::writeSignedInt($o, $v));
		CodecHelper::writeOptional($out, $data->defaultBlockPriority, fn($o, $v) => LE::writeSignedInt($o, $v));
		CodecHelper::writeString($out, $data->name);
	}
}
