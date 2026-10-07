<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ClientStoreEntrypointConfig;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ClientStoreEntrypointConfigSerializer implements SerializerInterface{
    use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : ClientStoreEntrypointConfig{
        return new ClientStoreEntrypointConfig(
            id: CodecHelper::readString($in),
            name: CodecHelper::readString($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof ClientStoreEntrypointConfig);

        CodecHelper::writeString($out, $data->id);
        CodecHelper::writeString($out, $data->name);
    }
}
