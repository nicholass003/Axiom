<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer\Biome;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Biome\ChunkGen\BiomeNoiseGradientSurfaceData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class BiomeNoiseGradientSurfaceDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : BiomeNoiseGradientSurfaceData{
		$nonReplaceableBlocks = CodecHelper::readList($in, fn($i) => LE::readUnsignedInt($i));

		$gradientBlocks = CodecHelper::readList($in, fn($i) => LE::readUnsignedInt($i));

		$noiseSeed = CodecHelper::readString($in);
		$firstOctave = LE::readUnsignedInt($in);

		$amplitudes = CodecHelper::readList($in, fn($i) => LE::readFloat($i));

		return new BiomeNoiseGradientSurfaceData(
			nonReplaceableBlocks: $nonReplaceableBlocks,
			gradientBlocks: $gradientBlocks,
			noiseSeed: $noiseSeed,
			firstOctave: $firstOctave,
			amplitudes: $amplitudes
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof BiomeNoiseGradientSurfaceData);

		CodecHelper::writeList($out, $data->nonReplaceableBlocks, fn($o, $v) => LE::writeUnsignedInt($o, $v));
		CodecHelper::writeList($out, $data->gradientBlocks, fn($o, $v) => LE::writeUnsignedInt($o, $v));

		CodecHelper::writeString($out, $data->noiseSeed);
		LE::writeUnsignedInt($out, $data->firstOctave);

		CodecHelper::writeList($out, $data->amplitudes, fn($o, $v) => LE::writeFloat($o, $v));
	}
}
