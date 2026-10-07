<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\DimensionData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class DimensionDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DimensionData{
		return new DimensionData(
			maxHeight: VarInt::readSignedInt($in),
			minHeight: VarInt::readSignedInt($in),
			generator: VarInt::readSignedInt($in),
			dimensionType: VarInt::readSignedInt($in),
			packId: CodecHelper::readUuid($in),
			defaultBiome: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DimensionData);

		VarInt::writeSignedInt($out, $data->maxHeight);
		VarInt::writeSignedInt($out, $data->minHeight);
		VarInt::writeSignedInt($out, $data->generator);
		VarInt::writeSignedInt($out, $data->dimensionType);
		CodecHelper::writeUuid($out, $data->packId);
		CodecHelper::writeString($out, $data->defaultBiome);
	}
}
