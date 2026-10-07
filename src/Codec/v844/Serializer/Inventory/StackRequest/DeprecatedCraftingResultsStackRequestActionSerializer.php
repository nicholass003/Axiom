<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingResultsStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\Byte;

class DeprecatedCraftingResultsStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DeprecatedCraftingResultsStackRequestAction{
		return new DeprecatedCraftingResultsStackRequestAction(
			results: CodecHelper::readList($in, fn($in) => CodecHelper::readItemStackWithoutStackId($in)),
			iterations: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DeprecatedCraftingResultsStackRequestAction);

		CodecHelper::writeList($out, $data->results, fn($out, $stack) => CodecHelper::writeItemStackWithoutStackId($out, $stack));
		Byte::writeUnsigned($out, $data->iterations);
	}
}
