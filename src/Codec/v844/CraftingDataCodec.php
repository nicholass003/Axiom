<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionContainerChangeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionTypeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CraftingDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CraftingDataPacket{
        $pk = new CraftingDataPacket();

        $recipeCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $recipeCount; ++$i){
            $pk->recipesWithTypeIds[] = $codec->read(RecipeWithTypeId::class, $in);
        }

        $potionTypeCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $potionTypeCount; ++$i){
            $pk->potionTypeRecipes[] = $codec->read(PotionTypeRecipe::class, $in);
        }

        $potionContainerCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $potionContainerCount; ++$i){
            $pk->potionContainerRecipes[] = $codec->read(PotionContainerChangeRecipe::class, $in);
        }

        $materialReducerCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $materialReducerCount; ++$i){
            $pk->materialReducerRecipes[] = $codec->read(MaterialReducerRecipe::class, $in);
        }

        $pk->cleanRecipes = CodecHelper::readBool($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CraftingDataPacket);

        VarInt::writeUnsignedInt($out, count($pk->recipesWithTypeIds));
        foreach($pk->recipesWithTypeIds as $recipe){
            $codec->write(RecipeWithTypeId::class, $out, $recipe);
        }

        VarInt::writeUnsignedInt($out, count($pk->potionTypeRecipes));
        foreach($pk->potionTypeRecipes as $recipe){
            $codec->write(PotionTypeRecipe::class, $out, $recipe);
        }

        VarInt::writeUnsignedInt($out, count($pk->potionContainerRecipes));
        foreach($pk->potionContainerRecipes as $recipe){
            $codec->write(PotionContainerChangeRecipe::class, $out, $recipe);
        }

        VarInt::writeUnsignedInt($out, count($pk->materialReducerRecipes));
        foreach($pk->materialReducerRecipes as $recipe){
            $codec->write(MaterialReducerRecipe::class, $out, $recipe);
        }

        CodecHelper::writeBool($out, $pk->cleanRecipes);
    }
}
