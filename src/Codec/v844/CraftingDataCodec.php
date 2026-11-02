<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Recipe\MaterialReducerRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\RecipeWithTypeId;
use Nicholass003\Axiom\Data\Type\Recipe\PotionContainerChangeRecipe;
use Nicholass003\Axiom\Data\Type\Recipe\PotionTypeRecipe;
use Nicholass003\Axiom\Packet\CraftingDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class CraftingDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : CraftingDataPacket{
        $pk = new CraftingDataPacket();

        $pk->recipesWithTypeIds = CodecHelper::readList($in, fn($i) => $codec->read(RecipeWithTypeId::class, $i));
        $pk->potionTypeRecipes = CodecHelper::readList($in, fn($i) => $codec->read(PotionTypeRecipe::class, $i));
        $pk->potionContainerRecipes = CodecHelper::readList($in, fn($i) => $codec->read(PotionContainerChangeRecipe::class, $i));
        $pk->materialReducerRecipes = CodecHelper::readList($in, fn($i) => $codec->read(MaterialReducerRecipe::class, $i));
        $pk->cleanRecipes = CodecHelper::readBool($in);

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof CraftingDataPacket);

        CodecHelper::writeList($out, $pk->recipesWithTypeIds, fn($o, $v) => $codec->write(RecipeWithTypeId::class, $o, $v));
        CodecHelper::writeList($out, $pk->potionTypeRecipes, fn($o, $v) => $codec->write(PotionTypeRecipe::class, $o, $v));
        CodecHelper::writeList($out, $pk->potionContainerRecipes, fn($o, $v) => $codec->write(PotionContainerChangeRecipe::class, $o, $v));
        CodecHelper::writeList($out, $pk->materialReducerRecipes, fn($o, $v) => $codec->write(MaterialReducerRecipe::class, $o, $v));
        CodecHelper::writeBool($out, $pk->cleanRecipes);
    }
}
