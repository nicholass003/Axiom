<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeUnlockingRequirement;
use Nicholass003\Axiom\Data\Type\Recipe\ShapelessRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ShapelessRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, RecipeType $typeId = RecipeType::UNKNOWN) : ShapelessRecipe{
		$recipeId = CodecHelper::readString($in);

		$inputCount = VarInt::readUnsignedInt($in);
		$inputs = [];
		for($i = 0; $i < $inputCount; $i++){
			$inputs[] = $codec->read(RecipeIngredient::class, $in);
		}

		$outputCount = VarInt::readUnsignedInt($in);
		$outputs = [];
		for($i = 0; $i < $outputCount; $i++){
			$outputs[] = CodecHelper::readItemStackWithoutStackId($in);
		}

		$uuid = CodecHelper::readUuid($in);
		$blockName = CodecHelper::readString($in);
		$priority = VarInt::readSignedInt($in);
		$unlockingRequirement = $codec->read(RecipeUnlockingRequirement::class, $in);
		$recipeNetId = CodecHelper::readRecipeNetId($in);

		return new ShapelessRecipe(
			typeId: $typeId,
			recipeId: $recipeId,
			inputs: $inputs,
			outputs: $outputs,
			uuid: $uuid,
			blockName: $blockName,
			priority: $priority,
			unlockingRequirement: $unlockingRequirement,
			recipeNetId: $recipeNetId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ShapelessRecipe);

		CodecHelper::writeString($out, $data->recipeId);
		VarInt::writeUnsignedInt($out, count($data->inputs));
		foreach($data->inputs as $ingredient){
			$codec->write(RecipeIngredient::class, $out, $ingredient);
		}
		VarInt::writeUnsignedInt($out, count($data->outputs));
		foreach($data->outputs as $item){
			CodecHelper::writeItemStackWithoutStackId($out, $item);
		}
		CodecHelper::writeUuid($out, $data->uuid);
		CodecHelper::writeString($out, $data->blockName);
		VarInt::writeSignedInt($out, $data->priority);
		$codec->write(RecipeUnlockingRequirement::class, $out, $data->unlockingRequirement);
		CodecHelper::writeRecipeNetId($out, $data->recipeNetId);
	}
}
