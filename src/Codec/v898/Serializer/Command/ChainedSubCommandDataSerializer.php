<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandRawData;
use Nicholass003\Axiom\Data\Type\Command\ChainedSubCommandValueRawData;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ChainedSubCommandDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ChainedSubCommandRawData{
		return new ChainedSubCommandRawData(
			name: CodecHelper::readString($in),
			valueData: CodecHelper::readList($in, fn($in) => $codec->read(ChainedSubCommandValueRawData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ChainedSubCommandRawData);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeList($out, $data->valueData, fn($out, $v) => $codec->write(ChainedSubCommandValueRawData::class, $out, $v));
	}
}
