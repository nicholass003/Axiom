<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Data\Type\LocatorBarWaypoint;
use Nicholass003\Axiom\Data\Type\LocatorBarWaypointPayload;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class LocatorBarWaypointPayloadSerializer implements SerializerInterface{

    public function read(ByteBufferReader $in, CodecType $codec) : LocatorBarWaypointPayload{
        return new LocatorBarWaypointPayload(
            uuid: CodecHelper::readUuid($in),
            waypoint: $codec->read(LocatorBarWaypoint::class, $in),
            action: Byte::readUnsigned($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof LocatorBarWaypointPayload);

        CodecHelper::writeUuid($out, $data->uuid);
        $codec->write(LocatorBarWaypoint::class, $out, $data->waypoint);
        Byte::writeUnsigned($out, $data->action);
    }
}
