<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\DataStore;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DataStore\StringDataStoreValue;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class StringDataStoreValueSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : StringDataStoreValue{
		return new StringDataStoreValue(
			value: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof StringDataStoreValue);
		CodecHelper::writeString($out, $data->value);
	}
}
