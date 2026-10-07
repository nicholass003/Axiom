<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\SubChunk;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SubChunkPosition{

    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $z
    ){}

    public static function read(ByteBufferReader $in) : self{
        return new self(
            VarInt::readSignedInt($in),
            VarInt::readSignedInt($in),
            VarInt::readSignedInt($in)
        );
    }

    public function write(ByteBufferWriter $out) : void{
        VarInt::writeSignedInt($out, $this->x);
        VarInt::writeSignedInt($out, $this->y);
        VarInt::writeSignedInt($out, $this->z);
    }
}
