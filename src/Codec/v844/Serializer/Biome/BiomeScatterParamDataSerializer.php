<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeCoordinateData;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeScatterParamData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class BiomeScatterParamDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeScatterParamData{
		return new BiomeScatterParamData(
			coordinates: CodecHelper::readList($in, fn($in) => $codec->read(BiomeCoordinateData::class, $in)),
			evalOrder: VarInt::readSignedInt($in),
			chancePercentType: VarInt::readSignedInt($in),
			chancePercent: LE::readSignedShort($in),
			chanceNumerator: LE::readSignedInt($in),
			chanceDenominator: LE::readSignedInt($in),
			iterationsType: VarInt::readSignedInt($in),
			iterations: LE::readSignedShort($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeScatterParamData);

		CodecHelper::writeList($out, $data->coordinates, fn($out, $v) => $codec->write(BiomeCoordinateData::class, $out, $v));
		VarInt::writeSignedInt($out, $data->evalOrder);
		VarInt::writeSignedInt($out, $data->chancePercentType);
		LE::writeSignedShort($out, $data->chancePercent);
		LE::writeSignedInt($out, $data->chanceNumerator);
		LE::writeSignedInt($out, $data->chanceDenominator);
		VarInt::writeSignedInt($out, $data->iterationsType);
		LE::writeSignedShort($out, $data->iterations);
	}
}
