<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\MultiRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionContainerChangeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionTypeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\ShapedRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\ShapelessRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTransformRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTrimRecipe;
use Nicholass003\Axiom\Enum\RecipeType;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CraftingDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CraftingDataPacket{
        $pk = new CraftingDataPacket();

        array_push(
            $pk->recipesWithTypeIds,
            ...CodecHelper::readList($in, fn($i) => $codec->get(ShapedRecipe::class)->read($i, $codec, RecipeType::SHAPED)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(ShapelessRecipe::class)->read($i, $codec, RecipeType::SHAPELESS)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(MultiRecipe::class)->read($i, $codec, RecipeType::MULTI)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(ShapelessRecipe::class)->read($i, $codec, RecipeType::USER_DATA_SHAPELESS)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(ShapelessRecipe::class)->read($i, $codec, RecipeType::SHAPELESS_CHEMISTRY)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(ShapedRecipe::class)->read($i, $codec, RecipeType::SHAPED_CHEMISTRY)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(SmithingTransformRecipe::class)->read($i, $codec, RecipeType::SMITHING_TRANSFORM)),
            ...CodecHelper::readList($in, fn($i) => $codec->get(SmithingTrimRecipe::class)->read($i, $codec, RecipeType::SMITHING_TRIM))
        );
        $pk->potionTypeRecipes = CodecHelper::readList($in, fn($i) => $codec->read(PotionTypeRecipe::class, $i));
        $pk->potionContainerRecipes = CodecHelper::readList($in, fn($i) => $codec->read(PotionContainerChangeRecipe::class, $i));
        $pk->materialReducerRecipes = CodecHelper::readList($in, fn($i) => $codec->read(MaterialReducerRecipe::class, $i));
        $pk->cleanRecipes = CodecHelper::readBool($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CraftingDataPacket);

        $recipes = [
        	RecipeType::SHAPED->value => [],
        	RecipeType::SHAPELESS->value => [],
        	RecipeType::MULTI->value => [],
        	RecipeType::USER_DATA_SHAPELESS->value => [],
        	RecipeType::SHAPELESS_CHEMISTRY->value => [],
        	RecipeType::SHAPED_CHEMISTRY->value => [],
        	RecipeType::SMITHING_TRANSFORM->value => [],
        	RecipeType::SMITHING_TRIM->value => []
        ];
        foreach($pk->recipesWithTypeIds as $recipe){
            $expectedClass = match($recipe->typeId){
                RecipeType::SHAPED,
                RecipeType::SHAPED_CHEMISTRY => ShapedRecipe::class,
                RecipeType::SHAPELESS,
                RecipeType::USER_DATA_SHAPELESS,
                RecipeType::SHAPELESS_CHEMISTRY => ShapelessRecipe::class,
                RecipeType::MULTI => MultiRecipe::class,
                RecipeType::SMITHING_TRANSFORM => SmithingTransformRecipe::class,
                RecipeType::SMITHING_TRIM => SmithingTrimRecipe::class,
                default => null
            };
            if($expectedClass !== null){
                if(!$recipe instanceof $expectedClass){
                    throw new \UnexpectedValueException("Recipe type {$recipe->typeId->name} does not match " . $recipe::class);
                }
                $recipes[$recipe->typeId->value][] = $recipe;
            }
        }

        CodecHelper::writeList($out, $recipes[RecipeType::SHAPED->value], fn($o, $v) => $codec->write(ShapedRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::SHAPELESS->value], fn($o, $v) => $codec->write(ShapelessRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::MULTI->value], fn($o, $v) => $codec->write(MultiRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::USER_DATA_SHAPELESS->value], fn($o, $v) => $codec->write(ShapelessRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::SHAPELESS_CHEMISTRY->value], fn($o, $v) => $codec->write(ShapelessRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::SHAPED_CHEMISTRY->value], fn($o, $v) => $codec->write(ShapedRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::SMITHING_TRANSFORM->value], fn($o, $v) => $codec->write(SmithingTransformRecipe::class, $o, $v));
        CodecHelper::writeList($out, $recipes[RecipeType::SMITHING_TRIM->value], fn($o, $v) => $codec->write(SmithingTrimRecipe::class, $o, $v));
        CodecHelper::writeList($out, $pk->potionTypeRecipes, fn($o, $v) => $codec->write(PotionTypeRecipe::class, $o, $v));
        CodecHelper::writeList($out, $pk->potionContainerRecipes, fn($o, $v) => $codec->write(PotionContainerChangeRecipe::class, $o, $v));
        CodecHelper::writeList($out, $pk->materialReducerRecipes, fn($o, $v) => $codec->write(MaterialReducerRecipe::class, $o, $v));
        CodecHelper::writeBool($out, $pk->cleanRecipes);
    }
}
