<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\MultiRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class MultiRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec,  RecipeType $typeId = RecipeType::MULTI) : MultiRecipe{
		$uuid = CodecHelper::readUuid($in);
		$recipeNetId = CodecHelper::readRecipeNetId($in);

		return new MultiRecipe(
			typeId: $typeId,
			recipeId: $uuid,
			recipeNetId: $recipeNetId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MultiRecipe);

		CodecHelper::writeUuid($out, $data->recipeId);
		CodecHelper::writeRecipeNetId($out, $data->recipeNetId);
	}
}
