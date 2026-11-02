<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Attribute;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class AttributeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : Attribute{
		$id = CodecHelper::readString($in);
		$max = LE::readFloat($in);
		$current = LE::readFloat($in);
		$min = LE::readFloat($in);
		return new Attribute(
			id: $id,
			min: $min,
			max: $max,
			current: $current
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof Attribute);

		CodecHelper::writeString($out, $data->id);
		LE::writeFloat($out, $data->min);
		LE::writeFloat($out, $data->current);
		LE::writeFloat($out, $data->max);
	}
}
