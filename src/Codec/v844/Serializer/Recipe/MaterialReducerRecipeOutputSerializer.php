<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipeOutput;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class MaterialReducerRecipeOutputSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MaterialReducerRecipeOutput{
		return new MaterialReducerRecipeOutput(
			itemId: VarInt::readSignedInt($in),
			count: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MaterialReducerRecipeOutput);

		VarInt::writeSignedInt($out, $data->itemId);
		VarInt::writeSignedInt($out, $data->count);
	}
}
