<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v944\Serializer\Voxel;

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
			cells: [$codec->read(SerializableVoxelCells::class, $in)],
			xCoordinates: CodecHelper::readList($in, fn($in) => LE::readFloat($in)),
			yCoordinates: CodecHelper::readList($in, fn($in) => LE::readFloat($in)),
			zCoordinates: CodecHelper::readList($in, fn($in) => LE::readFloat($in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SerializableVoxelShape);

		$codec->write(SerializableVoxelCells::class, $out, $data->cells[0]);
		CodecHelper::writeList($out, $data->xCoordinates, fn($out, $v) => LE::writeFloat($out, $v));
		CodecHelper::writeList($out, $data->yCoordinates, fn($out, $v) => LE::writeFloat($out, $v));
		CodecHelper::writeList($out, $data->zCoordinates, fn($out, $v) => LE::writeFloat($out, $v));
	}
}
