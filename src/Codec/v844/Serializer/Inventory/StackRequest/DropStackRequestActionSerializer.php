<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\DropStackRequestAction;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequestSlotInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class DropStackRequestActionSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : DropStackRequestAction{
		return new DropStackRequestAction(
			count: Byte::readUnsigned($in),
			source: $codec->read(ItemStackRequestSlotInfo::class, $in),
			randomly: CodecHelper::readBool($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof DropStackRequestAction);

		Byte::writeUnsigned($out, $data->count);
		$codec->write(ItemStackRequestSlotInfo::class, $out, $data->source);
		CodecHelper::writeBool($out, $data->randomly);
	}
}
