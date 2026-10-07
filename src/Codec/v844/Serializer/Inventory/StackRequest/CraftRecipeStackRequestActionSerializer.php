<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\Byte;
use pmmp\encoding\VarInt;

class CraftRecipeStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CraftRecipeStackRequestAction{
		return new CraftRecipeStackRequestAction(
			recipeId: VarInt::readUnsignedInt($in),
			repetitions: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CraftRecipeStackRequestAction);

		VarInt::writeUnsignedInt($out, $data->recipeId);
		Byte::writeUnsigned($out, $data->repetitions);
	}
}
