<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\FurnaceRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class FurnaceRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec,  RecipeType $typeId = RecipeType::UNKNOWN) : FurnaceRecipe{
		$inputId = VarInt::readSignedInt($in);
		$inputMeta = null;
		if($typeId === CraftingDataPacket::ENTRY_FURNACE_DATA){
			$inputMeta = VarInt::readSignedInt($in);
		}
		$result = CodecHelper::readItemStackWithoutStackId($in);
		$blockName = CodecHelper::readString($in);

		return new FurnaceRecipe(
			typeId: $typeId,
			inputId: $inputId,
			inputMeta: $inputMeta,
			result: $result,
			blockName: $blockName
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof FurnaceRecipe);

		VarInt::writeSignedInt($out, $data->inputId);
		if($data->typeId === CraftingDataPacket::ENTRY_FURNACE_DATA){
			VarInt::writeSignedInt($out, $data->inputMeta);
		}
		CodecHelper::writeItemStackWithoutStackId($out, $data->result);
		CodecHelper::writeString($out, $data->blockName);
	}
}
