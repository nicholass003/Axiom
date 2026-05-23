<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\Common\Serializer\InventorySerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Camera\CameraInstructionSerializer;
use Nicholass003\Axiom\Codec\v944\BlockPickRequestCodec;
use Nicholass003\Axiom\Codec\v944\ClientboundDataDrivenUICloseScreenCodec;
use Nicholass003\Axiom\Codec\v944\ClientboundDataDrivenUIShowScreenCodec;
use Nicholass003\Axiom\Codec\v944\GraphicsOverrideParameterCodec;
use Nicholass003\Axiom\Codec\v944\LocatorBarCodec;
use Nicholass003\Axiom\Codec\v944\PartyChangedCodec;
use Nicholass003\Axiom\Codec\v944\ResourcePacksReadyForValidationCodec;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\Instruction\CameraFovInstructionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Camera\Instruction\CameraSplineInstructionSerializer;
use Nicholass003\Axiom\Codec\v944\Serializer\Inventory\InventoryTransactionDataSerializer;
use Nicholass003\Axiom\Codec\v944\ServerboundDataDrivenScreenClosedCodec;
use Nicholass003\Axiom\Codec\v944\StartGameCodec;
use Nicholass003\Axiom\Codec\v944\UpdateClientInputLocksCodec;
use Nicholass003\Axiom\Codec\v944\VoxelShapesCodec;
use Nicholass003\Axiom\Packet\BlockPickRequestPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUICloseScreenPacket;
use Nicholass003\Axiom\Packet\ClientboundDataDrivenUIShowScreenPacket;
use Nicholass003\Axiom\Packet\GraphicsOverrideParameterPacket;
use Nicholass003\Axiom\Packet\LocatorBarPacket;
use Nicholass003\Axiom\Packet\PartyChangedPacket;
use Nicholass003\Axiom\Packet\ResourcePacksReadyForValidationPacket;
use Nicholass003\Axiom\Packet\ServerboundDataDrivenScreenClosedPacket;
use Nicholass003\Axiom\Packet\StartGamePacket;
use Nicholass003\Axiom\Packet\UpdateClientInputLocksPacket;
use Nicholass003\Axiom\Packet\VoxelShapesPacket;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol944 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codecType = Protocol924::buildCodecType()->fork();
        $cameraInstruction = new CameraInstructionSerializer(
            $codecType->cameraInstruction()->set(),
            $codecType->cameraInstruction()->fade(),
            $codecType->cameraInstruction()->target(),
            new CameraFovInstructionSerializer(),
            new CameraSplineInstructionSerializer()
        );
        $inventory = new InventorySerializer(
            $codecType->inventory()->request(),
            $codecType->inventory()->response(),
            $codecType->inventory()->container(),
            $codecType->inventory()->action(),
            new InventoryTransactionDataSerializer($codecType->inventory()->transaction()->action()),
            $codecType->inventory()->itemInteraction()
        );
        return $codecType
            ->withCameraInstruction($cameraInstruction)
            ->withInventory($inventory);
    }

    public static function build() : CodecBuilder{
        return Protocol924::build()->fork(ProtocolVersion::v944, "1.26.10")
            ->register(ResourcePacksReadyForValidationPacket::ID, new ResourcePacksReadyForValidationCodec())
            ->register(LocatorBarPacket::ID, new LocatorBarCodec())
            ->register(PartyChangedPacket::ID, new PartyChangedCodec())
            ->register(ServerboundDataDrivenScreenClosedPacket::ID, new ServerboundDataDrivenScreenClosedCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(StartGamePacket::ID, new StartGameCodec())
            ->override(BlockPickRequestPacket::ID, new BlockPickRequestCodec())
            ->override(ClientboundDataDrivenUICloseScreenPacket::ID, new ClientboundDataDrivenUICloseScreenCodec())
            ->override(ClientboundDataDrivenUIShowScreenPacket::ID, new ClientboundDataDrivenUIShowScreenCodec())
            ->override(GraphicsOverrideParameterPacket::ID, new GraphicsOverrideParameterCodec())
            ->override(VoxelShapesPacket::ID, new VoxelShapesCodec())
            ->override(UpdateClientInputLocksPacket::ID, new UpdateClientInputLocksCodec());
    }
}
