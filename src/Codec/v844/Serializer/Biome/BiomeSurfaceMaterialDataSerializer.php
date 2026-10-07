<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeSurfaceMaterialDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeSurfaceMaterialData{
		return new BiomeSurfaceMaterialData(
			topBlock: LE::readUnsignedInt($in),
			midBlock: LE::readUnsignedInt($in),
			seaFloorBlock: LE::readUnsignedInt($in),
			foundationBlock: LE::readUnsignedInt($in),
			seaBlock: LE::readUnsignedInt($in),
			seaFloorDepth: LE::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeSurfaceMaterialData);

		LE::writeUnsignedInt($out, $data->topBlock);
		LE::writeUnsignedInt($out, $data->midBlock);
		LE::writeUnsignedInt($out, $data->seaFloorBlock);
		LE::writeUnsignedInt($out, $data->foundationBlock);
		LE::writeUnsignedInt($out, $data->seaBlock);
		LE::writeSignedInt($out, $data->seaFloorDepth);
	}
}
