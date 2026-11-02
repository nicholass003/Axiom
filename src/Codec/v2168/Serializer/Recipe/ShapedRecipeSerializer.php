<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeUnlockingRequirement;
use Nicholass003\Axiom\Data\Type\Recipe\ShapedRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ShapedRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec, RecipeType $typeId = RecipeType::SHAPED) : ShapedRecipe{
		$recipeId = CodecHelper::readString($in);
		$width = VarInt::readSignedInt($in);
		$height = VarInt::readSignedInt($in);

		$input = [];
		for($row = 0; $row < $height; $row++){
			$rowData = [];
			for($col = 0; $col < $width; $col++){
				$rowData[] = $codec->read(RecipeIngredient::class, $in);
			}
			$input[] = $rowData;
		}

		$outputCount = VarInt::readUnsignedInt($in);
		$output = [];
		for($i = 0; $i < $outputCount; $i++){
			$output[] = $codec->read(ItemStack::class, $in);
		}

		$uuid = CodecHelper::readUuid($in);
		$blockName = CodecHelper::readString($in);
		$priority = VarInt::readSignedInt($in);
		$symmetric = CodecHelper::readBool($in);
		$unlockingRequirement = $codec->read(RecipeUnlockingRequirement::class, $in);
		$recipeNetId = CodecHelper::readRecipeNetId($in);

		return new ShapedRecipe(
			typeId: $typeId,
			recipeId: $recipeId,
			input: $input,
			output: $output,
			uuid: $uuid,
			blockName: $blockName,
			priority: $priority,
			symmetric: $symmetric,
			unlockingRequirement: $unlockingRequirement,
			recipeNetId: $recipeNetId
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ShapedRecipe);

		CodecHelper::writeString($out, $data->recipeId);
		VarInt::writeSignedInt($out, count($data->input[0] ?? []));
		VarInt::writeSignedInt($out, count($data->input));
		foreach($data->input as $row){
			foreach($row as $ingredient){
				$codec->write(RecipeIngredient::class, $out, $ingredient);
			}
		}
		VarInt::writeUnsignedInt($out, count($data->output));
		foreach($data->output as $item){
			$codec->write(ItemStack::class, $out, $item);
		}
		CodecHelper::writeUuid($out, $data->uuid);
		CodecHelper::writeString($out, $data->blockName);
		VarInt::writeSignedInt($out, $data->priority);
		CodecHelper::writeBool($out, $data->symmetric);
		$codec->write(RecipeUnlockingRequirement::class, $out, $data->unlockingRequirement);
		CodecHelper::writeRecipeNetId($out, $data->recipeNetId);
	}
}
