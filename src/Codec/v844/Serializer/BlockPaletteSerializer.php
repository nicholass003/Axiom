<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\BlockPaletteEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class BlockPaletteSerializer implements SerializerInterface{
	use StatelessForkable;

	/**
	 * @return list<BlockPaletteEntry>
	 */
	public function read(ByteBufferReader $in, CodecType $codec) : array{
		return CodecHelper::readList($in, fn($in) => new BlockPaletteEntry(
			name: CodecHelper::readString($in),
			nbt: CodecHelper::readNbt($in)
		));
	}

	/**
	 * @param list<BlockPaletteEntry> $palettes
	 */
	public function write(ByteBufferWriter $out, mixed $palettes, CodecType $codec) : void{
		CodecHelper::writeList($out, $palettes, fn($out, $palette) => [
			CodecHelper::writeString($out, $palette->name),
			CodecHelper::writeNbt($out, $palette->nbt)
		]);
	}
}
