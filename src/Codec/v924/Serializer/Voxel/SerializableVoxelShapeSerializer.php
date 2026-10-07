<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v924\Serializer\Voxel;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SerializableVoxelCells;
use Nicholass003\Axiom\Data\Type\SerializableVoxelShape;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class SerializableVoxelShapeSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SerializableVoxelShape{
		return new SerializableVoxelShape(
			cells: CodecHelper::readList($in, fn($i) => $codec->read(SerializableVoxelCells::class, $i)),
			xCoordinates: CodecHelper::readList($in, fn($i) => LE::readFloat($i)),
			yCoordinates: CodecHelper::readList($in, fn($i) => LE::readFloat($i)),
			zCoordinates: CodecHelper::readList($in, fn($i) => LE::readFloat($i))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SerializableVoxelShape);

		CodecHelper::writeList($out, $data->cells, fn($o, $v) => $codec->write(SerializableVoxelCells::class, $o, $v));
		CodecHelper::writeList($out, $data->xCoordinates, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeList($out, $data->yCoordinates, fn($o, $v) => LE::writeFloat($o, $v));
		CodecHelper::writeList($out, $data->zCoordinates, fn($o, $v) => LE::writeFloat($o, $v));
	}
}
