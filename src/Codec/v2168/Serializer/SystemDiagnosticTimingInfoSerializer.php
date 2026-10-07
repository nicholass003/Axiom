<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\SystemDiagnosticTimingInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class SystemDiagnosticTimingInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SystemDiagnosticTimingInfo{
		return new SystemDiagnosticTimingInfo(
			displayName: CodecHelper::readString($in),
			systemIndex: LE::readUnsignedLong($in),
			timeInNS: LE::readUnsignedLong($in),
			percentOfTotal: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SystemDiagnosticTimingInfo);

		CodecHelper::writeString($out, $data->displayName);
		LE::writeUnsignedLong($out, $data->systemIndex);
		LE::writeUnsignedLong($out, $data->timeInNS);
		Byte::writeUnsigned($out, $data->percentOfTotal);
	}
}
