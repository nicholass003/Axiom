<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

interface SerializerInterface{

	public function read(ByteBufferReader $in, CodecType $codec) : mixed;

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void;
}
