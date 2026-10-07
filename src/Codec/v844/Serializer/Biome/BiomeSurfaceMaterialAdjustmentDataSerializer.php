<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeElementData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeSurfaceMaterialAdjustmentData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BiomeSurfaceMaterialAdjustmentDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeSurfaceMaterialAdjustmentData{
		return new BiomeSurfaceMaterialAdjustmentData(
			adjustments: CodecHelper::readList($in, fn($in) => $codec->read(BiomeElementData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeSurfaceMaterialAdjustmentData);

		CodecHelper::writeList($out, $data->adjustments, fn($out, $v) => $codec->write(BiomeElementData::class, $out, $v));
	}
}
