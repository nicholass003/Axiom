<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Version\Protocol;

use Nicholass003\Axiom\Codec\CodecBuilder;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\v859\AnimateCodec;
use Nicholass003\Axiom\Codec\v859\CameraInstructionCodec;
use Nicholass003\Axiom\Codec\v859\ClientboundDataStoreCodec;
use Nicholass003\Axiom\Codec\v859\GraphicsOverrideParameterCodec;
use Nicholass003\Axiom\Codec\v859\Serializer\Biome\BiomeDefinitionChunkGenDataSerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Biome\BiomeReplacementDataSerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Camera\CameraProgressOptionSerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Camera\CameraRotationOptionSerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Camera\CameraSplineInstructionSerializer;
use Nicholass003\Axiom\Codec\v859\Serializer\Debug\PacketShapeDataSerializer;
use Nicholass003\Axiom\Codec\v859\ShowStoreOfferCodec;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeDefinitionChunkGenData;
use Nicholass003\Axiom\Data\Type\Camera\CameraProgressOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraRotationOption;
use Nicholass003\Axiom\Data\Type\Camera\CameraSplineInstruction;
use Nicholass003\Axiom\Data\Type\Debug\PacketShapeData;
use Nicholass003\Axiom\Packet\AnimatePacket;
use Nicholass003\Axiom\Packet\CameraInstructionPacket;
use Nicholass003\Axiom\Packet\ClientboundDataStorePacket;
use Nicholass003\Axiom\Packet\GraphicsOverrideParameterPacket;
use Nicholass003\Axiom\Packet\ShowStoreOfferPacket;
use Nicholass003\Axiom\Version\MinecraftVersionNetwork;
use Nicholass003\Axiom\Version\ProtocolVersion;

class Protocol859 implements ProtocolInterface{

    public static function buildCodecType() : CodecType{
        $codec = Protocol844::buildCodecType()->fork();
        $codec->override(CameraSplineInstruction::class, new CameraSplineInstructionSerializer());
        $codec->override(CameraProgressOption::class, new CameraProgressOptionSerializer());
        $codec->override(CameraRotationOption::class, new CameraRotationOptionSerializer());
        $codec->override(BiomeReplacementData::class, new BiomeReplacementDataSerializer());
        $codec->override(BiomeDefinitionChunkGenData::class, new BiomeDefinitionChunkGenDataSerializer());
        $codec->override(PacketShapeData::class, new PacketShapeDataSerializer());
        return $codec;
    }

    public static function build(?MinecraftVersionNetwork $mc = null) : CodecBuilder{
        return Protocol844::build()->fork(ProtocolVersion::v859, $mc?->__toString() ?? "1.21.120")
            ->register(ClientboundDataStorePacket::ID, new ClientboundDataStoreCodec())
            ->register(GraphicsOverrideParameterPacket::ID, new GraphicsOverrideParameterCodec())
            ->override(ShowStoreOfferPacket::ID, new ShowStoreOfferCodec())
            ->overrideCodecType(self::buildCodecType())
            ->override(AnimatePacket::ID, new AnimateCodec())
            ->override(CameraInstructionPacket::ID, new CameraInstructionCodec());
    }
}
