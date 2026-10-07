<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequestSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\SwapStackRequestAction;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class SwapStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SwapStackRequestAction{
		return new SwapStackRequestAction(
			slot1: $codec->read(ItemStackRequestSlotInfo::class, $in),
			slot2: $codec->read(ItemStackRequestSlotInfo::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SwapStackRequestAction);

		$codec->write(ItemStackRequestSlotInfo::class, $out, $data->slot1);
		$codec->write(ItemStackRequestSlotInfo::class, $out, $data->slot2);
	}
}
