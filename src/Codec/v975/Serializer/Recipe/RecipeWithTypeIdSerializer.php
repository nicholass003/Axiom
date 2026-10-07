<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\MultiRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Data\Type\Recipe\ShapedRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\ShapelessRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTransformRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTrimRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class RecipeWithTypeIdSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : RecipeWithTypeId{
		$typeId = RecipeType::safe(VarInt::readSignedInt($in));

		return match($typeId){
			RecipeType::SHAPELESS,
			RecipeType::USER_DATA_SHAPELESS,
			RecipeType::SHAPELESS_CHEMISTRY => $codec->get(ShapelessRecipe::class)->read($in, $codec, $typeId),
			RecipeType::SHAPED,
			RecipeType::SHAPED_CHEMISTRY => $codec->get(ShapedRecipe::class)->read($in, $codec, $typeId),
			RecipeType::MULTI => $codec->get(MultiRecipe::class)->read($in, $codec, $typeId),
			RecipeType::SMITHING_TRANSFORM => $codec->get(SmithingTransformRecipe::class)->read($in, $codec, $typeId),
			RecipeType::SMITHING_TRIM => $codec->get(SmithingTrimRecipe::class)->read($in, $codec, $typeId),
			default => throw new \RuntimeException("Unknown recipe type $typeId")
		};
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof RecipeWithTypeId);

		VarInt::writeSignedInt($out, $data->typeId->value);

		if($data instanceof ShapelessRecipe){
			$codec->write(ShapelessRecipe::class, $out, $data);
		}elseif($data instanceof ShapedRecipe){
			$codec->write(ShapedRecipe::class, $out, $data);
		}elseif($data instanceof MultiRecipe){
			$codec->write(MultiRecipe::class, $out, $data);
		}elseif($data instanceof SmithingTransformRecipe){
			$codec->write(SmithingTransformRecipe::class, $out, $data);
		}elseif($data instanceof SmithingTrimRecipe){
			$codec->write(SmithingTrimRecipe::class, $out, $data);
		}else{
			throw new \RuntimeException("Unknown recipe type " . $data::class);
		}
	}
}
