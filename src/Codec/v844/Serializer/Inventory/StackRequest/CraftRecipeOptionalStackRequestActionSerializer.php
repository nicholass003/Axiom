<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeOptionalStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class CraftRecipeOptionalStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CraftRecipeOptionalStackRequestAction{
		return new CraftRecipeOptionalStackRequestAction(
			recipeId: VarInt::readUnsignedInt($in),
			filterStringIndex: LE::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CraftRecipeOptionalStackRequestAction);

		VarInt::writeUnsignedInt($out, $data->recipeId);
		LE::writeSignedInt($out, $data->filterStringIndex);
	}
}
