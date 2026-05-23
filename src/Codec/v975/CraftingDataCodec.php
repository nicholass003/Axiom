<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v844\CraftingDataCodec as V844CraftingDataCodec;
use Nicholass003\Axiom\Data\Type\Recipe\MultiRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Data\Type\Recipe\ShapedRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\ShapelessRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTransformRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\SmithingTrimRecipe;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class CraftingDataCodec extends V844CraftingDataCodec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CraftingDataPacket{
        $pk = new CraftingDataPacket();
        $recipeCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $recipeCount; ++$i){
            $recipeType = VarInt::readSignedInt($in);
            $pk->recipesWithTypeIds[] = $this->readRecipeWithTypeId($in, $recipeType, $codec);
        }
        $potionTypeCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $potionTypeCount; ++$i){
            $pk->potionTypeRecipes[] = $codec->recipe()->readPotionTypeRecipe($in);
        }
        $potionContainerCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $potionContainerCount; ++$i){
            $pk->potionContainerRecipes[] = $codec->recipe()->readPotionContainerChangeRecipe($in);
        }
        $materialReducerCount = VarInt::readUnsignedInt($in);
        for($i = 0; $i < $materialReducerCount; ++$i){
            $pk->materialReducerRecipes[] = $codec->recipe()->readMaterialReducerRecipe($in);
        }
        $pk->cleanRecipes = CodecHelper::readBool($in);
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CraftingDataPacket);
        VarInt::writeUnsignedInt($out, count($pk->recipesWithTypeIds));
        foreach($pk->recipesWithTypeIds as $recipe){
            VarInt::writeSignedInt($out, $recipe->typeId);
            $this->writeRecipeWithTypeId($out, $recipe, $codec);
        }
        VarInt::writeUnsignedInt($out, count($pk->potionTypeRecipes));
        foreach($pk->potionTypeRecipes as $recipe){
            $codec->recipe()->writePotionTypeRecipe($out, $recipe);
        }
        VarInt::writeUnsignedInt($out, count($pk->potionContainerRecipes));
        foreach($pk->potionContainerRecipes as $recipe){
            $codec->recipe()->writePotionContainerChangeRecipe($out, $recipe);
        }
        VarInt::writeUnsignedInt($out, count($pk->materialReducerRecipes));
        foreach($pk->materialReducerRecipes as $recipe){
            $codec->recipe()->writeMaterialReducerRecipe($out, $recipe);
        }
        CodecHelper::writeBool($out, $pk->cleanRecipes);
    }

    protected function readRecipeWithTypeId(ByteBufferReader $in, int $recipeType, CodecType $codec) : RecipeWithTypeId{
        return match($recipeType){
            CraftingDataPacket::ENTRY_SHAPELESS,
            CraftingDataPacket::ENTRY_USER_DATA_SHAPELESS,
            CraftingDataPacket::ENTRY_SHAPELESS_CHEMISTRY => $this->readShapelessRecipe($in, $recipeType, $codec),
            CraftingDataPacket::ENTRY_SHAPED,
            CraftingDataPacket::ENTRY_SHAPED_CHEMISTRY => $this->readShapedRecipe($in, $recipeType, $codec),
            CraftingDataPacket::ENTRY_MULTI => $this->readMultiRecipe($in, $recipeType),
            CraftingDataPacket::ENTRY_SMITHING_TRANSFORM => $this->readSmithingTransformRecipe($in, $recipeType, $codec),
            CraftingDataPacket::ENTRY_SMITHING_TRIM => $this->readSmithingTrimRecipe($in, $recipeType, $codec),
            default => throw new \RuntimeException("Unknown recipe type $recipeType")
        };
    }

    protected function writeRecipeWithTypeId(ByteBufferWriter $out, RecipeWithTypeId $recipe, CodecType $codec) : void{
        if($recipe instanceof ShapelessRecipe){
            $this->writeShapelessRecipe($out, $recipe, $codec);
        }elseif($recipe instanceof ShapedRecipe){
            $this->writeShapedRecipe($out, $recipe, $codec);
        }elseif($recipe instanceof MultiRecipe){
            $this->writeMultiRecipe($out, $recipe);
        }elseif($recipe instanceof SmithingTransformRecipe){
            $this->writeSmithingTransformRecipe($out, $recipe, $codec);
        }elseif($recipe instanceof SmithingTrimRecipe){
            $this->writeSmithingTrimRecipe($out, $recipe, $codec);
        }else{
            throw new \RuntimeException("Unknown recipe type " . $recipe::class);
        }
    }
}
