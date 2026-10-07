<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\BeaconPaymentStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftingConsumeInputStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftingCreateSpecificResultStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeAutoStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeOptionalStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CraftRecipeStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\CreativeCreateStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingNonImplementedStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingResultsStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DestroyStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DropStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\GrindstoneStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequest;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\LabTableCombineStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\LoomStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\MineBlockStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\PlaceStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\SwapStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\TakeStackRequestAction;
use Nicholass003\Axiom\Enum\ItemStackRequestActionType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ItemStackRequestSerializer implements SerializerInterface{
	use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : ItemStackRequest{
        $requestId = VarInt::readSignedInt($in);

        $size = VarInt::readUnsignedInt($in);
        $actions = [];

        for($i = 0; $i < $size; $i++){
            $type = ItemStackRequestActionType::safe(Byte::readUnsigned($in));
            $actions[] = match($type){
                ItemStackRequestActionType::TAKE => $codec->read(TakeStackRequestAction::class, $in),
                ItemStackRequestActionType::PLACE => $codec->read(PlaceStackRequestAction::class, $in),
                ItemStackRequestActionType::SWAP => $codec->read(SwapStackRequestAction::class, $in),
                ItemStackRequestActionType::DROP => $codec->read(DropStackRequestAction::class, $in),
                ItemStackRequestActionType::DESTROY => $codec->read(DestroyStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_CONSUME_INPUT => $codec->read(CraftingConsumeInputStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_CREATE_SPECIFIC_RESULT => $codec->read(CraftingCreateSpecificResultStackRequestAction::class, $in),
                ItemStackRequestActionType::LAB_TABLE_COMBINE => $codec->read(LabTableCombineStackRequestAction::class, $in),
                ItemStackRequestActionType::BEACON_PAYMENT => $codec->read(BeaconPaymentStackRequestAction::class, $in),
                ItemStackRequestActionType::MINE_BLOCK => $codec->read(MineBlockStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_RECIPE => $codec->read(CraftRecipeStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_RECIPE_AUTO => $codec->read(CraftRecipeAutoStackRequestAction::class, $in),
                ItemStackRequestActionType::CREATIVE_CREATE => $codec->read(CreativeCreateStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_RECIPE_OPTIONAL => $codec->read(CraftRecipeOptionalStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_GRINDSTONE => $codec->read(GrindstoneStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_LOOM => $codec->read(LoomStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_NON_IMPLEMENTED_DEPRECATED_ASK_TY_LAING => $codec->read(DeprecatedCraftingNonImplementedStackRequestAction::class, $in),
                ItemStackRequestActionType::CRAFTING_RESULTS_DEPRECATED_ASK_TY_LAING => $codec->read(DeprecatedCraftingResultsStackRequestAction::class, $in),
            };
        }

        $filterStrings = CodecHelper::readList($in, fn($in) => CodecHelper::readString($in));
        $filterStringCause = LE::readSignedInt($in);

        return new ItemStackRequest($requestId, $actions, $filterStrings, $filterStringCause);
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof ItemStackRequest);

        VarInt::writeSignedInt($out, $data->requestId);

        VarInt::writeUnsignedInt($out, count($data->actions));

        foreach($data->actions as $action){
            Byte::writeUnsigned($out, $action->type->value);
            match($action->type){
                ItemStackRequestActionType::TAKE => $codec->write(TakeStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::PLACE => $codec->write(PlaceStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::SWAP => $codec->write(SwapStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::DROP => $codec->write(DropStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::DESTROY => $codec->write(DestroyStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_CONSUME_INPUT => $codec->write(CraftingConsumeInputStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_CREATE_SPECIFIC_RESULT => $codec->write(CraftingCreateSpecificResultStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::LAB_TABLE_COMBINE => $codec->write(LabTableCombineStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::BEACON_PAYMENT => $codec->write(BeaconPaymentStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::MINE_BLOCK => $codec->write(MineBlockStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_RECIPE => $codec->write(CraftRecipeStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_RECIPE_AUTO => $codec->write(CraftRecipeAutoStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CREATIVE_CREATE => $codec->write(CreativeCreateStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_RECIPE_OPTIONAL => $codec->write(CraftRecipeOptionalStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_GRINDSTONE => $codec->write(GrindstoneStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_LOOM => $codec->write(LoomStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_NON_IMPLEMENTED_DEPRECATED_ASK_TY_LAING => $codec->write(DeprecatedCraftingNonImplementedStackRequestAction::class, $out, $action),
                ItemStackRequestActionType::CRAFTING_RESULTS_DEPRECATED_ASK_TY_LAING => $codec->write(DeprecatedCraftingResultsStackRequestAction::class, $out, $action),
            };
        }

        CodecHelper::writeList($out, $data->filterStrings, fn($out, $s) => CodecHelper::writeString($out, $s));
        LE::writeSignedInt($out, $data->filterStringCause);
    }
}
