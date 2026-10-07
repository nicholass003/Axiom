<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Trim;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Trim\TrimMaterial;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class TrimMaterialSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : TrimMaterial{
		return new TrimMaterial(
			materialId: CodecHelper::readString($in),
			color: CodecHelper::readString($in),
			itemId: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof TrimMaterial);

		CodecHelper::writeString($out, $data->materialId);
		CodecHelper::writeString($out, $data->color);
		CodecHelper::writeString($out, $data->itemId);
	}
}
