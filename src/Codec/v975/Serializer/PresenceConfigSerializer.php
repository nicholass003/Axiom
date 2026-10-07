<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\PresenceConfig;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class PresenceConfigSerializer implements SerializerInterface{
    use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : PresenceConfig{
        return new PresenceConfig(
            experienceName: CodecHelper::readString($in),
            worldName: CodecHelper::readString($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof PresenceConfig);

        CodecHelper::writeString($out, $data->experienceName);
        CodecHelper::writeString($out, $data->worldName);
    }
}
