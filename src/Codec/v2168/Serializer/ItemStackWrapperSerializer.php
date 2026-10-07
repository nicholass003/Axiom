<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ItemStack;
use Nicholass003\Axiom\Data\Type\ItemStackWrapper;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ItemStackWrapperSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStackWrapper{
		$id = LE::readSignedShort($in);
		if($id === 0){
			return new ItemStackWrapper(0, new ItemStack(0, 0, 0, 0, ''));
		}
		$count = LE::readUnsignedShort($in);
		$meta = VarInt::readUnsignedInt($in);
		$hasNetId = CodecHelper::readBool($in);
		$stackId = $hasNetId ? VarInt::readSignedInt($in) : 0;
		$blockRuntimeId = VarInt::readUnsignedInt($in);
		$rawExtraData = CodecHelper::readString($in);

		return new ItemStackWrapper($stackId, new ItemStack($id, $meta, $count, $blockRuntimeId, $rawExtraData));
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackWrapper);

		$item = $data->itemStack;
		if($item->id === 0){
			LE::writeSignedShort($out, 0);
			return;
		}
		LE::writeSignedShort($out, $item->id);
		LE::writeUnsignedShort($out, $item->count);
		VarInt::writeUnsignedInt($out, $item->meta);
		$hasNetId = $data->stackId !== 0;
		CodecHelper::writeBool($out, $hasNetId);
		if($hasNetId){
			VarInt::writeSignedInt($out, $data->stackId);
		}
		VarInt::writeUnsignedInt($out, $item->blockRuntimeId);
		CodecHelper::writeString($out, $item->rawExtraData);
	}
}
