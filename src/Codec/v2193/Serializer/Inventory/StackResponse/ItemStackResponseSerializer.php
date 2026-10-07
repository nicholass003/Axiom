<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2193\Serializer\Inventory\StackResponse;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponse;
use Nicholass003\Axiom\Data\Type\Inventory\StackResponse\ItemStackResponseContainerInfo;
use Nicholass003\Axiom\Enum\ItemStackResponseResult;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class ItemStackResponseSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackResponse{
		$result = ItemStackResponseResult::safe(Byte::readUnsigned($in));
		$requestId = CodecHelper::readItemStackRequestId($in);
		$containerInfos = CodecHelper::readOptional($in, static fn($i) => CodecHelper::readList($in, $codec->read(ItemStackResponseContainerInfo::class, $i)));

		return new ItemStackResponse(
			$result,
			$requestId,
			$containerInfos
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackResponse);

		Byte::writeUnsigned($out, $data->result->value);
		CodecHelper::writeItemStackRequestId($out, $data->requestId);
		CodecHelper::writeOptional($out, $data->containerInfos, static fn($out, $list) => CodecHelper::writeList($out, $list, static fn($o, $v) => $codec->write(ItemStackResponseContainerInfo::class, $o, $v)));
	}
}
