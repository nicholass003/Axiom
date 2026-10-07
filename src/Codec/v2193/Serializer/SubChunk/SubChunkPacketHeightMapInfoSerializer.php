<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketHeightMapInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class SubChunkPacketHeightMapInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	private const ROW_LENGTH = 16;
	private const TOTAL_LENGTH = self::ROW_LENGTH ** 2;

	public function read(ByteBufferReader $in, CodecType $codec) : SubChunkPacketHeightMapInfo{
		$heights = [];
		for($i = 0; $i < self::TOTAL_LENGTH; ++$i){
			if(($i & (self::ROW_LENGTH - 1)) === 0){
				$rowLength = VarInt::readUnsignedInt($in);
				if($rowLength !== self::ROW_LENGTH){
					throw new \RuntimeException("Expected height map row to hold exactly " . self::ROW_LENGTH . " heights, got $rowLength");
				}
			}
			$heights[] = Byte::readSigned($in);
		}
		return new SubChunkPacketHeightMapInfo(heights: $heights);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SubChunkPacketHeightMapInfo);

		foreach($data->heights as $i => $height){
			if(($i & (self::ROW_LENGTH - 1)) === 0){
				VarInt::writeUnsignedInt($out, self::ROW_LENGTH);
			}
			Byte::writeSigned($out, $height);
		}
	}
}