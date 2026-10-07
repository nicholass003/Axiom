<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipeOutput;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class MaterialReducerRecipeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MaterialReducerRecipe{
		$inputIdAndData = VarInt::readSignedInt($in);
		$inputId = $inputIdAndData >> 16;
		$inputMeta = $inputIdAndData & 0x7fff;
		$outputs = CodecHelper::readList($in, fn($in) => $codec->read(MaterialReducerRecipeOutput::class, $in));
		return new MaterialReducerRecipe(
			inputItemId: $inputId,
			inputItemMeta: $inputMeta,
			outputs: $outputs
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MaterialReducerRecipe);

		VarInt::writeSignedInt($out, ($data->inputItemId << 16) | $data->inputItemMeta);
		CodecHelper::writeList($out, $data->outputs, fn($out, $o) => $codec->write(MaterialReducerRecipeOutput::class, $out, $o));
	}
}
