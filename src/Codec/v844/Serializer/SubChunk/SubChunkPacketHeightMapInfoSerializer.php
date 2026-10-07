<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\SubChunk;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SubChunk\SubChunkPacketHeightMapInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SubChunkPacketHeightMapInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SubChunkPacketHeightMapInfo{
		$heights = [];
		for($i = 0; $i < 256; $i++){
			$heights[] = Byte::readSigned($in);
		}
		return new SubChunkPacketHeightMapInfo(heights: $heights);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SubChunkPacketHeightMapInfo);

		for($i = 0; $i < 256; $i++){
			Byte::writeSigned($out, $data->heights[$i]);
		}
	}
}
