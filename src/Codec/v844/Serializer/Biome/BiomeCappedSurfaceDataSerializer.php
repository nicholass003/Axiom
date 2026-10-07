<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCappedSurfaceData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeCappedSurfaceDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeCappedSurfaceData{
		return new BiomeCappedSurfaceData(
			floorBlocks: CodecHelper::readList($in, LE::readUnsignedInt(...)),
			ceilingBlocks: CodecHelper::readList($in, LE::readUnsignedInt(...)),
			seaBlock: CodecHelper::readOptional($in, LE::readUnsignedInt(...)),
			foundationBlock: CodecHelper::readOptional($in, LE::readUnsignedInt(...)),
			beachBlock: CodecHelper::readOptional($in, LE::readUnsignedInt(...))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeCappedSurfaceData);

		CodecHelper::writeList($out, $data->floorBlocks, LE::writeUnsignedInt(...));
		CodecHelper::writeList($out, $data->ceilingBlocks, LE::writeUnsignedInt(...));
		CodecHelper::writeOptional($out, $data->seaBlock, LE::writeUnsignedInt(...));
		CodecHelper::writeOptional($out, $data->foundationBlock, LE::writeUnsignedInt(...));
		CodecHelper::writeOptional($out, $data->beachBlock, LE::writeUnsignedInt(...));
	}
}
