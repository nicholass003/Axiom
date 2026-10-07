<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeMesaSurfaceData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeMesaSurfaceDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeMesaSurfaceData{
		return new BiomeMesaSurfaceData(
			clayMaterial: LE::readUnsignedInt($in),
			hardClayMaterial: LE::readUnsignedInt($in),
			brycePillars: CodecHelper::readBool($in),
			forest: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeMesaSurfaceData);

		LE::writeUnsignedInt($out, $data->clayMaterial);
		LE::writeUnsignedInt($out, $data->hardClayMaterial);
		CodecHelper::writeBool($out, $data->brycePillars);
		CodecHelper::writeBool($out, $data->forest);
	}
}
