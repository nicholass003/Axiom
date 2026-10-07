<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequestSlotInfo;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\TakeStackRequestAction;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class TakeStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : TakeStackRequestAction{
		return new TakeStackRequestAction(
			count: Byte::readUnsigned($in),
			source: $codec->read(ItemStackRequestSlotInfo::class, $in),
			destination: $codec->read(ItemStackRequestSlotInfo::class, $in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof TakeStackRequestAction);

		Byte::writeUnsigned($out, $data->count);
		$codec->write(ItemStackRequestSlotInfo::class, $out, $data->source);
		$codec->write(ItemStackRequestSlotInfo::class, $out, $data->destination);
	}
}
