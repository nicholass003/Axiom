<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DeprecatedCraftingNonImplementedStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class DeprecatedCraftingNonImplementedStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DeprecatedCraftingNonImplementedStackRequestAction{
		return new DeprecatedCraftingNonImplementedStackRequestAction();
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DeprecatedCraftingNonImplementedStackRequestAction);
		// No data to write
	}
}
