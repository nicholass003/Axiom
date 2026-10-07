<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\ResourcePack;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackStackEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ResourcePackStackEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ResourcePackStackEntry{
		return new ResourcePackStackEntry(
			packId: CodecHelper::readString($in),
			version: CodecHelper::readString($in),
			subPackName: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ResourcePackStackEntry);

		CodecHelper::writeString($out, $data->packId);
		CodecHelper::writeString($out, $data->version);
		CodecHelper::writeString($out, $data->subPackName);
	}
}
