<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMountainParamsData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeMountainParamsDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeMountainParamsData{
		return new BiomeMountainParamsData(
			steepBlock: LE::readUnsignedInt($in),
			northSlopes: CodecHelper::readBool($in),
			southSlopes: CodecHelper::readBool($in),
			westSlopes: CodecHelper::readBool($in),
			eastSlopes: CodecHelper::readBool($in),
			topSlideEnabled: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeMountainParamsData);

		LE::writeUnsignedInt($out, $data->steepBlock);
		CodecHelper::writeBool($out, $data->northSlopes);
		CodecHelper::writeBool($out, $data->southSlopes);
		CodecHelper::writeBool($out, $data->westSlopes);
		CodecHelper::writeBool($out, $data->eastSlopes);
		CodecHelper::writeBool($out, $data->topSlideEnabled);
	}
}
