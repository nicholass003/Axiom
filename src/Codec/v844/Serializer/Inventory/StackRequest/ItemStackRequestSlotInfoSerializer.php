<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackRequest;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\Inventory\StackRequest\ItemStackRequestSlotInfo;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ItemStackRequestSlotInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackRequestSlotInfo{
		return new ItemStackRequestSlotInfo(
			containerName: $codec->read(FullContainerName::class, $in),
			slotId: Byte::readUnsigned($in),
			stackId: CodecHelper::readItemStackNetIdVariant($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackRequestSlotInfo);

		$codec->write(FullContainerName::class, $out, $data->containerName);
		Byte::writeUnsigned($out, $data->slotId);
		CodecHelper::writeItemStackNetIdVariant($out, $data->stackId);
	}
}
