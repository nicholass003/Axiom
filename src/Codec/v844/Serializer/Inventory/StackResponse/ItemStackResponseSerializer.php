<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Inventory\StackResponse;

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
use pmmp\encoding\VarInt;

class ItemStackResponseSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackResponse{
		$result = ItemStackResponseResult::safe(Byte::readUnsigned($in));
		$requestId = VarInt::readSignedInt($in);
		$containerInfos = [];
		if($result === ItemStackResponseResult::OK){
			$containerInfos = CodecHelper::readList($in, fn($i) => $codec->read(ItemStackResponseContainerInfo::class, $i));
		}
		return new ItemStackResponse($result, $requestId, $containerInfos);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackResponse);

		Byte::writeUnsigned($out, $data->result->value);
		VarInt::writeSignedInt($out, $data->requestId);
		if($data->result === ItemStackResponseResult::OK){
			CodecHelper::writeList($out, $data->containerInfos, fn($o, $v) => $codec->write(ItemStackResponseContainerInfo::class, $o, $v));
		}
	}
}
