<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v859\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\BiomeReplacementData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class BiomeReplacementDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeReplacementData{
		return new BiomeReplacementData(
			biome: LE::readSignedShort($in),
			dimension: VarInt::readSignedInt($in),
			targetBiomes: CodecHelper::readList($in, LE::readSignedShort(...)),
			amount: LE::readFloat($in),
			replacementIndex: LE::readUnsignedInt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeReplacementData);

		LE::writeSignedShort($out, $data->biome);
		VarInt::writeSignedInt($out, $data->dimension);
		CodecHelper::writeList($out, $data->targetBiomes, LE::writeSignedShort(...));
		LE::writeFloat($out, $data->amount);
		LE::writeUnsignedInt($out, $data->replacementIndex);
	}
}
