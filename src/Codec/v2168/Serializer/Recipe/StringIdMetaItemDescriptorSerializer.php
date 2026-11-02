<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\StringIdMetaItemDescriptor;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class StringIdMetaItemDescriptorSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : StringIdMetaItemDescriptor{
		return new StringIdMetaItemDescriptor(
			id: CodecHelper::readString($in),
			meta: LE::readUnsignedShort($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof StringIdMetaItemDescriptor);

		CodecHelper::writeString($out, $data->id);
		LE::writeUnsignedShort($out, $data->meta);
	}
}
