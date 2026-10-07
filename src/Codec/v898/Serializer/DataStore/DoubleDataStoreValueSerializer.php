<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\DataStore;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DataStore\DoubleDataStoreValue;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class DoubleDataStoreValueSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DoubleDataStoreValue{
		return new DoubleDataStoreValue(
			value: LE::readDouble($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DoubleDataStoreValue);
		LE::writeDouble($out, $data->value);
	}
}
