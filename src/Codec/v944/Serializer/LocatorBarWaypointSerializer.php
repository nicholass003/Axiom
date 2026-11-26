<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\LocatorBarWaypoint;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class LocatorBarWaypointSerializer implements SerializerInterface{
    use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : LocatorBarWaypoint{
        return new LocatorBarWaypoint(
            updateFlag: LE::readUnsignedInt($in),
            visible: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
            worldPosition: CodecHelper::readOptional($in, CodecHelper::readWorldPosition(...)),
            textureId: CodecHelper::readOptional($in, LE::readUnsignedInt(...)),
            texturePath: null,
            iconSize: null,
            color: CodecHelper::readOptional($in, LE::readUnsignedInt(...)),
            clientPositionAuthority: CodecHelper::readOptional($in, CodecHelper::readBool(...)),
            actorUniqueId: CodecHelper::readOptional($in, CodecHelper::readActorUniqueId(...))
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof LocatorBarWaypoint);

        LE::writeUnsignedInt($out, $data->updateFlag);
        CodecHelper::writeOptional($out, $data->visible, CodecHelper::writeBool(...));
        CodecHelper::writeOptional($out, $data->worldPosition, CodecHelper::writeWorldPosition(...));
        CodecHelper::writeOptional($out, $data->textureId, LE::writeUnsignedInt(...));
        CodecHelper::writeOptional($out, $data->color, LE::writeUnsignedInt(...));
        CodecHelper::writeOptional($out, $data->clientPositionAuthority, CodecHelper::writeBool(...));
        CodecHelper::writeOptional($out, $data->actorUniqueId, CodecHelper::writeActorUniqueId(...));
    }
}
