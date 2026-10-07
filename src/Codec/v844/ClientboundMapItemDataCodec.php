<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Map\MapDataFlags;
use Nicholass003\Axiom\Data\Type\Map\MapDecoration;
use Nicholass003\Axiom\Data\Type\Map\MapImage;
use Nicholass003\Axiom\Data\Type\Map\MapTrackedObject;
use Nicholass003\Axiom\Packet\ClientboundMapItemDataPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class ClientboundMapItemDataCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ClientboundMapItemDataPacket{
        $pk = new ClientboundMapItemDataPacket();
        $pk->mapId = CodecHelper::readActorUniqueId($in);
        $pk->type = MapDataFlags::fromInt(VarInt::readUnsignedInt($in));
        $pk->dimensionId = Byte::readUnsigned($in);
        $pk->isLocked = CodecHelper::readBool($in);
        $pk->origin = CodecHelper::readSignedBlockPosition($in);

        if($pk->type->hasMapCreation()){
            $pk->parentMapIds = CodecHelper::readList($in, fn($i) => CodecHelper::readActorUniqueId($i));
        }

        if($pk->type->requiresScale()){
            $pk->scale = Byte::readUnsigned($in);
        }

        if($pk->type->hasDecorationUpdate()){
            $pk->trackedEntities = CodecHelper::readList($in, fn($i) => $codec->read(MapTrackedObject::class, $i));
            $pk->decorations = CodecHelper::readList($in, fn($i) => $codec->read(MapDecoration::class, $i));
        }

        if($pk->type->hasTextureUpdate()){
            $width = VarInt::readSignedInt($in);
            $height = VarInt::readSignedInt($in);
            $pk->xOffset = VarInt::readSignedInt($in);
            $pk->yOffset = VarInt::readSignedInt($in);
            $pixelCount = VarInt::readUnsignedInt($in);
            $expectedCount = $width * $height;
            if($pixelCount !== $expectedCount){
                throw new \RuntimeException("Expected pixel count $expectedCount, got $pixelCount");
            }
            $pk->colors = $codec->get(MapImage::class)->read($in, $codec, $width, $height);
        }

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ClientboundMapItemDataPacket);
        CodecHelper::writeActorUniqueId($out, $pk->mapId);
        VarInt::writeUnsignedInt($out, $pk->type->toInt());
        Byte::writeUnsigned($out, $pk->dimensionId);
        CodecHelper::writeBool($out, $pk->isLocked);
        CodecHelper::writeSignedBlockPosition($out, $pk->origin);

        if($pk->type->hasMapCreation()){
            CodecHelper::writeList($out, $pk->parentMapIds, fn($out, $v) => CodecHelper::writeActorUniqueId($out, $v));
        }

        if($pk->type->requiresScale()){
            Byte::writeUnsigned($out, $pk->scale ?? throw new \InvalidArgumentException("Scale required"));
        }

        if($pk->type->hasDecorationUpdate()){
            CodecHelper::writeList($out, $pk->trackedEntities, fn($out, $v) => $codec->write(MapTrackedObject::class, $out, $v));
            CodecHelper::writeList($out, $pk->decorations, fn($out, $v) => $codec->write(MapDecoration::class, $out, $v));
        }

        if($pk->type->hasTextureUpdate()){
            $image = $pk->colors ?? throw new \InvalidArgumentException("Image required");
            VarInt::writeSignedInt($out, $image->width);
            VarInt::writeSignedInt($out, $image->height);
            VarInt::writeSignedInt($out, $pk->xOffset);
            VarInt::writeSignedInt($out, $pk->yOffset);
            VarInt::writeUnsignedInt($out, $image->width * $image->height);
            $codec->write(MapImage::class, $out, $image);
        }
    }
}
