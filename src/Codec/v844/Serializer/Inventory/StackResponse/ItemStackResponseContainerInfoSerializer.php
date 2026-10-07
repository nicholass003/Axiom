<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackResponse;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\FullContainerName;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseContainerInfo;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseSlotInfo;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ItemStackResponseContainerInfoSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackResponseContainerInfo{
		return new ItemStackResponseContainerInfo(
			containerName: $codec->read(FullContainerName::class, $in),
			slots: CodecHelper::readList($in, fn($in) => $codec->read(ItemStackResponseSlotInfo::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackResponseContainerInfo);

		$codec->write(FullContainerName::class, $out, $data->containerName);
		CodecHelper::writeList($out, $data->slots, fn($out, $v) => $codec->write(ItemStackResponseSlotInfo::class, $out, $v));
	}
}
