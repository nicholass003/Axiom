<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeAutoStackRequestAction;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CraftRecipeAutoStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CraftRecipeAutoStackRequestAction{
		return new CraftRecipeAutoStackRequestAction(
			recipeId: VarInt::readSignedInt($in),
			repetitions: VarInt::readSignedInt($in),
			repetitions2: VarInt::readSignedInt($in),
			ingredients: CodecHelper::readList($in, fn($in) => $codec->read(RecipeIngredient::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CraftRecipeAutoStackRequestAction);

		VarInt::writeSignedInt($out, $data->recipeId);
		VarInt::writeSignedInt($out, $data->repetitions);
		VarInt::writeSignedInt($out, $data->repetitions2);
		CodecHelper::writeList($out, $data->ingredients, fn($out, $v) => $codec->write(RecipeIngredient::class, $out, $v));
	}
}
