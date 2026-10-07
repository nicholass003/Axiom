<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\SubChunk;

use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class SubChunkPacketEntry{

    public function __construct(
        public readonly int $result,
        public readonly int $blobId,
        public readonly array $subChunkOffsets = [],
        public readonly int $hardCodedNodeId = 0,
        public readonly string $subChunkData = ''
    ){}

    public static function read(ByteBufferReader $in) : self{
        $result = LE::readUnsignedInt($in);
        $blobId = VarInt::readSignedLong($in);
        $subChunkOffsets = [];
        $hardCodedNodeId = 0;
        $subChunkData = '';

        if($result === 0){
            $count = VarInt::readUnsignedInt($in);
            for($i = 0; $i < $count; $i++){
                $subChunkOffsets[] = VarInt::readUnsignedInt($in);
            }
        }elseif($result === 1){
            $hardCodedNodeId = VarInt::readUnsignedInt($in);
        }elseif($result === 2){
            $subChunkData = $in->readByteArray(VarInt::readUnsignedInt($in));
        }

        return new self($result, $blobId, $subChunkOffsets, $hardCodedNodeId, $subChunkData);
    }

    public function write(ByteBufferWriter $out) : void{
        LE::writeUnsignedInt($out, $this->result);
        VarInt::writeSignedLong($out, $this->blobId);

        if($this->result === 0){
            VarInt::writeUnsignedInt($out, count($this->subChunkOffsets));
            foreach($this->subChunkOffsets as $offset){
                VarInt::writeUnsignedInt($out, $offset);
            }
        }elseif($this->result === 1){
            VarInt::writeUnsignedInt($out, $this->hardCodedNodeId);
        }elseif($this->result === 2){
            VarInt::writeUnsignedInt($out, strlen($this->subChunkData));
            $out->writeByteArray($this->subChunkData);
        }
    }
}
