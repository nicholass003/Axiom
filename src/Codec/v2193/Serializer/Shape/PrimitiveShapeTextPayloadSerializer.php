<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\Shape;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Shape\PrimitiveShapeTextPayload;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class PrimitiveShapeTextPayloadSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : PrimitiveShapeTextPayload{
		$text = CodecHelper::readString($in);
		$useRotation = CodecHelper::readBool($in);
		$backgroundColor = CodecHelper::readOptional($in, CodecHelper::readColor(...));
		$lineGapHeight = LE::readFloat($in);
		$depthTest = CodecHelper::readBool($in);
		$showBackface = CodecHelper::readBool($in);
		$showTextBackface = CodecHelper::readBool($in);

		return new PrimitiveShapeTextPayload(
			$text,
			$useRotation,
			$backgroundColor,
			$lineGapHeight,
			$depthTest,
			$showBackface,
			$showTextBackface
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof PrimitiveShapeTextPayload);

		CodecHelper::writeString($out, $data->text);
		CodecHelper::writeBool($out, $data->useRotation);
		CodecHelper::writeOptional($out, $data->backgroundColor, CodecHelper::writeColor(...));
		LE::writeFloat($out, $data->lineGapHeight);
		CodecHelper::writeBool($out, $data->depthTest);
		CodecHelper::writeBool($out, $data->showBackface);
		CodecHelper::writeBool($out, $data->showTextBackface);
	}
}