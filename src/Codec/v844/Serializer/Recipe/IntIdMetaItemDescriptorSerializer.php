<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\IntIdMetaItemDescriptor;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class IntIdMetaItemDescriptorSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : IntIdMetaItemDescriptor{
		return new IntIdMetaItemDescriptor(
			id: LE::readSignedShort($in),
			meta: LE::readSignedShort($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof IntIdMetaItemDescriptor);

		LE::writeSignedShort($out, $data->id);
		LE::writeSignedShort($out, $data->meta);
	}
}
