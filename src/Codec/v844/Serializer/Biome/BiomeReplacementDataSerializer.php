<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeReplacementDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeReplacementData{
		return new BiomeReplacementData(
			biome: LE::readSignedInt($in),
			dimension: LE::readSignedInt($in),
			targetBiomes: CodecHelper::readList($in, LE::readSignedInt(...)),
			amount: LE::readFloat($in),
			replacementIndex: LE::readSignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeReplacementData);

		LE::writeSignedInt($out, $data->biome);
		LE::writeSignedInt($out, $data->dimension);
		CodecHelper::writeList($out, $data->targetBiomes, LE::writeSignedInt(...));
		LE::writeFloat($out, $data->amount);
		LE::writeSignedInt($out, $data->replacementIndex);
	}
}
