<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\PotionContainerChangeRecipe;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class PotionContainerChangeRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PotionContainerChangeRecipe{
		return new PotionContainerChangeRecipe(
			inputItemId: VarInt::readSignedInt($in),
			ingredientItemId: VarInt::readSignedInt($in),
			outputItemId: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PotionContainerChangeRecipe);

		VarInt::writeSignedInt($out, $data->inputItemId);
		VarInt::writeSignedInt($out, $data->ingredientItemId);
		VarInt::writeSignedInt($out, $data->outputItemId);
	}
}
