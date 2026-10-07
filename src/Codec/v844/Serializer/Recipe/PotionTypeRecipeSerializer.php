<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\PotionTypeRecipe;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class PotionTypeRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PotionTypeRecipe{
		return new PotionTypeRecipe(
			inputItemId: VarInt::readSignedInt($in),
			inputItemMeta: VarInt::readSignedInt($in),
			ingredientItemId: VarInt::readSignedInt($in),
			ingredientItemMeta: VarInt::readSignedInt($in),
			outputItemId: VarInt::readSignedInt($in),
			outputItemMeta: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PotionTypeRecipe);

		VarInt::writeSignedInt($out, $data->inputItemId);
		VarInt::writeSignedInt($out, $data->inputItemMeta);
		VarInt::writeSignedInt($out, $data->ingredientItemId);
		VarInt::writeSignedInt($out, $data->ingredientItemMeta);
		VarInt::writeSignedInt($out, $data->outputItemId);
		VarInt::writeSignedInt($out, $data->outputItemMeta);
	}
}
