<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\EntityDiagnosticTimingInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class EntityDiagnosticTimingInfoSerializer implements SerializerInterface{
    use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : EntityDiagnosticTimingInfo{
        return new EntityDiagnosticTimingInfo(
            displayName: CodecHelper::readString($in),
            entity: CodecHelper::readString($in),
            timeInNS: LE::readUnsignedLong($in),
            percentOfTotal: Byte::readUnsigned($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof EntityDiagnosticTimingInfo);

        CodecHelper::writeString($out, $data->displayName);
        CodecHelper::writeString($out, $data->entity);
        LE::writeUnsignedLong($out, $data->timeInNS);
        Byte::writeUnsigned($out, $data->percentOfTotal);
    }
}
