<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Voxel;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SerializableVoxelCells;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SerializableVoxelCellsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SerializableVoxelCells{
		return new SerializableVoxelCells(
			xSize: Byte::readUnsigned($in),
			ySize: Byte::readUnsigned($in),
			zSize: Byte::readUnsigned($in),
			storage: CodecHelper::readList($in, fn($i) => Byte::readUnsigned($i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SerializableVoxelCells);

		Byte::writeUnsigned($out, $data->xSize);
		Byte::writeUnsigned($out, $data->ySize);
		Byte::writeUnsigned($out, $data->zSize);
		CodecHelper::writeList($out, $data->storage, fn($o, $v) => Byte::writeUnsigned($o, $v));
	}
}
