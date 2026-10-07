<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequest;
use Nicholass003\Axiom\Data\Type\ItemInteractionData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputVehicleInfo;
use Nicholass003\Axiom\Data\Type\PlayerBlockActionData;
use Nicholass003\Axiom\Enum\InputMode;
use Nicholass003\Axiom\Enum\PlayerAuthInputFlag;
use Nicholass003\Axiom\Enum\PlayMode;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\PlayerAuthInputPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class PlayerAuthInputCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : PlayerAuthInputPacket{
        $pk = new PlayerAuthInputPacket();
        $pitch = LE::readFloat($in);
        $yaw = LE::readFloat($in);
        $position = CodecHelper::readVec3($in);
        $moveX = LE::readFloat($in);
        $moveZ = LE::readFloat($in);
        $headYaw = LE::readFloat($in);
        $flags = CodecHelper::readBitSet($in, PlayerAuthInputFlag::NUMBER_OF_FLAGS->value);
        $inputMode = InputMode::safe(VarInt::readUnsignedInt($in));
        $playMode = PlayMode::safe(VarInt::readUnsignedInt($in));
        $interactionMode = VarInt::readUnsignedInt($in);
        $interactRotation = CodecHelper::readVec2($in);
        $tick = VarInt::readUnsignedLong($in);
        $delta = CodecHelper::readVec3($in);
        $itemInteraction = null;
        if($flags->has(PlayerAuthInputFlag::PERFORM_ITEM_INTERACTION->value)){
            $itemInteraction = $codec->read(ItemInteractionData::class, $in);
        }
        $itemStackRequest = null;
        if($flags->has(PlayerAuthInputFlag::PERFORM_ITEM_STACK_REQUEST->value)){
            $itemStackRequest = $codec->read(ItemStackRequest::class, $in);
        }
        $blockActions = null;
        if($flags->has(PlayerAuthInputFlag::PERFORM_BLOCK_ACTIONS->value)){
            $count = VarInt::readSignedInt($in);
            $blockActions = [];
            for($i = 0; $i < $count; ++$i){
                $blockActions[] = $codec->read(PlayerBlockActionData::class, $in);
            }
        }
        $vehicleInfo = null;
        if($flags->has(PlayerAuthInputFlag::IN_CLIENT_PREDICTED_VEHICLE->value)){
            $vehicleInfo = new PlayerAuthInputVehicleInfo(
                LE::readFloat($in),
                LE::readFloat($in),
                CodecHelper::readActorUniqueId($in)
            );
        }
        $analogX = LE::readFloat($in);
        $analogZ = LE::readFloat($in);
        $camera = CodecHelper::readVec3($in);
        $rawMove = CodecHelper::readVec2($in);
        $pk->input = new PlayerAuthInputData(
            $position,
            $pitch,
            $yaw,
            $headYaw,
            $moveX,
            $moveZ,
            $flags,
            $inputMode,
            $playMode,
            $interactionMode,
            $interactRotation,
            $tick,
            $delta,
            $itemInteraction,
            $itemStackRequest,
            $blockActions,
            $vehicleInfo,
            $analogX,
            $analogZ,
            $camera,
            $rawMove
        );

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof PlayerAuthInputPacket);
        $d = $pk->input;
        LE::writeFloat($out, $d->pitch);
        LE::writeFloat($out, $d->yaw);
        CodecHelper::writeVec3($out, $d->position);
        LE::writeFloat($out, $d->moveVecX);
        LE::writeFloat($out, $d->moveVecZ);
        LE::writeFloat($out, $d->headYaw);
        CodecHelper::writeBitSet($out, $d->inputFlags);
        VarInt::writeUnsignedInt($out, $d->inputMode->value);
        VarInt::writeUnsignedInt($out, $d->playMode->value);
        VarInt::writeUnsignedInt($out, $d->interactionMode);
        CodecHelper::writeVec2($out, $d->interactRotation);
        VarInt::writeUnsignedLong($out, $d->tick);
        CodecHelper::writeVec3($out, $d->delta);
        if($d->itemInteractionData !== null){
            $codec->write(ItemInteractionData::class, $out, $d->itemInteractionData);
        }
        if($d->itemStackRequest !== null){
            $codec->write(ItemStackRequest::class, $out, $d->itemStackRequest);
        }
        if($d->blockActions !== null){
            VarInt::writeSignedInt($out, count($d->blockActions));
            foreach($d->blockActions as $action){
                $codec->write(PlayerBlockActionData::class, $out, $action);
            }
        }
        if($d->vehicleInfo !== null){
            LE::writeFloat($out, $d->vehicleInfo->vehicleRotationX);
            LE::writeFloat($out, $d->vehicleInfo->vehicleRotationZ);
            CodecHelper::writeActorUniqueId($out, $d->vehicleInfo->predictedVehicleActorUniqueId);
        }
        LE::writeFloat($out, $d->analogMoveVecX);
        LE::writeFloat($out, $d->analogMoveVecZ);
        CodecHelper::writeVec3($out, $d->cameraOrientation);
        CodecHelper::writeVec2($out, $d->rawMove);
    }
}
