<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCoordinateData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class BiomeCoordinateDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeCoordinateData{
		return new BiomeCoordinateData(
			minValueType: VarInt::readSignedInt($in),
			minValue: LE::readSignedShort($in),
			maxValueType: VarInt::readSignedInt($in),
			maxValue: LE::readSignedShort($in),
			gridOffset: LE::readUnsignedInt($in),
			gridStepSize: LE::readUnsignedInt($in),
			distribution: VarInt::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeCoordinateData);

		VarInt::writeSignedInt($out, $data->minValueType);
		LE::writeSignedShort($out, $data->minValue);
		VarInt::writeSignedInt($out, $data->maxValueType);
		LE::writeSignedShort($out, $data->maxValue);
		LE::writeUnsignedInt($out, $data->gridOffset);
		LE::writeUnsignedInt($out, $data->gridStepSize);
		VarInt::writeSignedInt($out, $data->distribution);
	}
}
