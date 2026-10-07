<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Enchant;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Enchant\Enchant;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EnchantSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : Enchant{
		return new Enchant(
			id: Byte::readUnsigned($in),
			level: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof Enchant);

		Byte::writeUnsigned($out, $data->id);
		Byte::writeUnsigned($out, $data->level);
	}
}
