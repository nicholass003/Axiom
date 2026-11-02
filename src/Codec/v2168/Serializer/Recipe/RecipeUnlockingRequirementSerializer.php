<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeUnlockingRequirement;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class RecipeUnlockingRequirementSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : RecipeUnlockingRequirement{
		$unlockingContext = CodecHelper::readBool($in);
		$ingredients = null;
		if(!$unlockingContext){
			$ingredients = CodecHelper::readList($in, fn($in) => $codec->read(RecipeIngredient::class, $in));
		}
		return new RecipeUnlockingRequirement(
			unlockingIngredients: $ingredients
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof RecipeUnlockingRequirement);

		CodecHelper::writeBool($out, $data->unlockingIngredients === null);
		if($data->unlockingIngredients !== null){
			CodecHelper::writeList($out, $data->unlockingIngredients, fn($out, $i) => $codec->write(RecipeIngredient::class, $out, $i));
		}
	}
}
