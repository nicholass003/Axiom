<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\BitSet;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequest;
use Nicholass003\Axiom\Data\Type\ItemInteractionData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputData;
use Nicholass003\Axiom\Data\Type\PlayerAuthInputVehicleInfo;
use Nicholass003\Axiom\Data\Type\PlayerBlockActionData;
use Nicholass003\Axiom\Data\Type\Vec2;
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

        $flagsList = CodecHelper::readList($in, VarInt::readSignedInt(...));
        $flags = new BitSet(PlayerAuthInputFlag::NUMBER_OF_FLAGS->value, []);
        foreach($flagsList as $flag){
            $flags = $flags->with($flag, true);
        }

        $inputMode = InputMode::safe(VarInt::readUnsignedInt($in));
        $playMode = PlayMode::safe(VarInt::readUnsignedInt($in));
        $interactionMode = VarInt::readSignedInt($in);
        $interactRotation = CodecHelper::readVec2($in);
        $tick = VarInt::readUnsignedLong($in);
        $delta = CodecHelper::readVec3($in);

        $itemInteraction = CodecHelper::readOptional($in, fn($i) => $codec->read(ItemInteractionData::class, $i));
        $itemStackRequest = CodecHelper::readOptional($in, fn($i) => $codec->read(ItemStackRequest::class, $i));
        $blockActions = CodecHelper::readOptional($in, static fn($in) => CodecHelper::readList($in, fn($i) => $codec->read(PlayerBlockActionData::class, $i)));

        $vehicleRotation = CodecHelper::readOptional($in, CodecHelper::readVec2(...));
        $vehicleActorUniqueId = CodecHelper::readOptional($in, CodecHelper::readActorUniqueId(...));
        $vehicleInfo = null;
        if($vehicleRotation !== null && $vehicleActorUniqueId !== null){
            $vehicleInfo = new PlayerAuthInputVehicleInfo(
                $vehicleRotation->x,
                $vehicleRotation->y,
                $vehicleActorUniqueId
            );
        }elseif($vehicleRotation === null && $vehicleActorUniqueId === null){
            $vehicleInfo = null;
        }else{
            throw new \RuntimeException("Vehicle rotation and actor unique ID must both be present or both be absent");
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

        $flagsArray = [];
        for($i = 0; $i < PlayerAuthInputFlag::NUMBER_OF_FLAGS->value; ++$i){
            if($d->inputFlags->get($i)){
                $flagsArray[] = $i;
            }
        }
        CodecHelper::writeList($out, $flagsArray, fn($out, $v) => VarInt::writeSignedInt($out, $v));

        VarInt::writeUnsignedInt($out, $d->inputMode->value);
        VarInt::writeUnsignedInt($out, $d->playMode->value);
        VarInt::writeSignedInt($out, $d->interactionMode);
        CodecHelper::writeVec2($out, $d->interactRotation);
        VarInt::writeUnsignedLong($out, $d->tick);
        CodecHelper::writeVec3($out, $d->delta);

        CodecHelper::writeOptional($out, $d->itemInteractionData, static fn($out, $data) => $codec->write(ItemInteractionData::class, $out, $data));
        CodecHelper::writeOptional($out, $d->itemStackRequest, static fn($out, $request) => $codec->write(ItemStackRequest::class, $out, $request));
        CodecHelper::writeOptional($out, $d->blockActions, static fn($out, $actions) => CodecHelper::writeList($out, $actions, static fn($out, $action) => $codec->write(PlayerBlockActionData::class, $out, $action)));

        $vehicleRotation = $d->vehicleInfo !== null ? new Vec2($d->vehicleInfo->vehicleRotationX, $d->vehicleInfo->vehicleRotationZ) : null;
        CodecHelper::writeOptional($out, $vehicleRotation, CodecHelper::writeVec2(...));
        CodecHelper::writeOptional($out, $d->vehicleInfo !== null ? $d->vehicleInfo->predictedVehicleActorUniqueId : null, CodecHelper::writeActorUniqueId(...));

        LE::writeFloat($out, $d->analogMoveVecX);
        LE::writeFloat($out, $d->analogMoveVecZ);
        CodecHelper::writeVec3($out, $d->cameraOrientation);
        CodecHelper::writeVec2($out, $d->rawMove);
    }
}
