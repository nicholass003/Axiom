<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Recipe;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Recipe\ComplexAliasItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\IntIdMetaItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\MolangItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeIngredient;
use Nicholass003\Axiom\Data\Type\Recipe\StringIdMetaItemDescriptor;
use Nicholass003\Axiom\Data\Type\Recipe\TagItemDescriptor;
use Nicholass003\Axiom\Enum\ItemDescriptorType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class RecipeIngredientSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : RecipeIngredient{
		$type = ItemDescriptorType::fromLegacy(Byte::readUnsigned($in));
		$descriptor = match($type){
			ItemDescriptorType::INT_ID_META => $codec->read(IntIdMetaItemDescriptor::class, $in),
			ItemDescriptorType::MOLANG => $codec->read(MolangItemDescriptor::class, $in),
			ItemDescriptorType::TAG => $codec->read(TagItemDescriptor::class, $in),
			ItemDescriptorType::STRING_ID_META => $codec->read(StringIdMetaItemDescriptor::class, $in),
			ItemDescriptorType::COMPLEX_ALIAS => $codec->read(ComplexAliasItemDescriptor::class, $in),
			default => null
		};
		$count = VarInt::readSignedInt($in);
		return new RecipeIngredient(
			descriptor: $descriptor,
			count: $count
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof RecipeIngredient);

		if($data->descriptor === null){
			Byte::writeUnsigned($out, 0);
		}else{
			$type = $data->descriptor::ID;
			Byte::writeUnsigned($out, $type->toLegacy());
			match($type){
				ItemDescriptorType::INT_ID_META => $codec->write(IntIdMetaItemDescriptor::class, $out, $data->descriptor),
				ItemDescriptorType::MOLANG => $codec->write(MolangItemDescriptor::class, $out, $data->descriptor),
				ItemDescriptorType::TAG => $codec->write(TagItemDescriptor::class, $out, $data->descriptor),
				ItemDescriptorType::STRING_ID_META => $codec->write(StringIdMetaItemDescriptor::class, $out, $data->descriptor),
				ItemDescriptorType::COMPLEX_ALIAS => $codec->write(ComplexAliasItemDescriptor::class, $out, $data->descriptor),
				default => throw new \InvalidArgumentException("Unknown descriptor type")
			};
		}
		VarInt::writeSignedInt($out, $data->count);
	}
}
