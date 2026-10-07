<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Attribute;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\AttributeLayer;
use Nicholass003\Axiom\Data\Type\AttributeUpdateLayers;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class AttributeUpdateLayersSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : AttributeUpdateLayers{
		$layers = [];
		for($i = 0, $len = VarInt::readUnsignedInt($in); $i < $len; ++$i){
			$layers[] = $codec->read(AttributeLayer::class, $in);
		}

		return new AttributeUpdateLayers(
			layers: $layers
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof AttributeUpdateLayers);

		VarInt::writeUnsignedInt($out, count($data->layers));
		foreach($data->layers as $layer){
			$codec->write(AttributeLayer::class, $out, $layer);
		}
	}
}
