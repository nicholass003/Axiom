<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ItemTypeEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ItemTypeEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemTypeEntry{
		return new ItemTypeEntry(
			stringId: CodecHelper::readString($in),
			numericId: LE::readSignedShort($in),
			componentBased: CodecHelper::readBool($in),
			version: VarInt::readSignedInt($in),
			componentNbt: CodecHelper::readNbt($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemTypeEntry);

		CodecHelper::writeString($out, $data->stringId);
		LE::writeSignedShort($out, $data->numericId);
		CodecHelper::writeBool($out, $data->componentBased);
		VarInt::writeSignedInt($out, $data->version);
		CodecHelper::writeNbt($out, $data->componentNbt);
	}
}
