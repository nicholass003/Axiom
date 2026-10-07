<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\LabTableCombineStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class LabTableCombineStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : LabTableCombineStackRequestAction{
		return new LabTableCombineStackRequestAction();
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof LabTableCombineStackRequestAction);
		// No data to write
	}
}
