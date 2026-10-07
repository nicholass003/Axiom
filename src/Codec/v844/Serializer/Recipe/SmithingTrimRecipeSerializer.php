<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTrimRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SmithingTrimRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec,  RecipeType $typeId = RecipeType::UNKNOWN) : SmithingTrimRecipe{
		$recipeId = CodecHelper::readString($in);
		$template = $codec->read(RecipeIngredient::class, $in);
		$input = $codec->read(RecipeIngredient::class, $in);
		$addition = $codec->read(RecipeIngredient::class, $in);
		$blockName = CodecHelper::readString($in);
		$recipeNetId = CodecHelper::readRecipeNetId($in);

		return new SmithingTrimRecipe(
			typeId: $typeId,
			recipeId: $recipeId,
			template: $template,
			input: $input,
			addition: $addition,
			blockName: $blockName,
			recipeNetId: $recipeNetId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SmithingTrimRecipe);

		CodecHelper::writeString($out, $data->recipeId);
		$codec->write(RecipeIngredient::class, $out, $data->template);
		$codec->write(RecipeIngredient::class, $out, $data->input);
		$codec->write(RecipeIngredient::class, $out, $data->addition);
		CodecHelper::writeString($out, $data->blockName);
		CodecHelper::writeRecipeNetId($out, $data->recipeNetId);
	}
}
