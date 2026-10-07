<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Map;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Map\MapTrackedObject;
use Nicholass003\Axiom\Enum\MapTrackedObjectType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class MapTrackedObjectSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MapTrackedObject{
		$rawType = LE::readUnsignedInt($in);
		$type = MapTrackedObjectType::safe($rawType);

		return match($type){
			MapTrackedObjectType::ENTITY => new MapTrackedObject(
				type: $type,
				actorUniqueId: CodecHelper::readActorUniqueId($in)
			),
			MapTrackedObjectType::BLOCK => new MapTrackedObject(
				type: $type,
				blockPosition: CodecHelper::readBlockPosition($in)
			),
			MapTrackedObjectType::UNKNOWN => throw new \RuntimeException("Unknown map object type $rawType")
		};
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MapTrackedObject);

		LE::writeUnsignedInt($out, $data->type->value);
		if($data->type === MapTrackedObjectType::ENTITY){
			CodecHelper::writeActorUniqueId($out, $data->actorUniqueId ?? throw new \InvalidArgumentException("Entity tracked object requires actor unique ID"));
		}elseif($data->type === MapTrackedObjectType::BLOCK){
			CodecHelper::writeBlockPosition($out, $data->blockPosition ?? throw new \InvalidArgumentException("Block tracked object requires block position"));
		}else{
			throw new \InvalidArgumentException("Unknown map object type");
		}
	}
}
