<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v975\Serializer;

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
		$count = LE::readUnsignedShort($in);
		$meta = VarInt::readUnsignedInt($in);

		$hasNetId = CodecHelper::readBool($in);
		if($hasNetId){
			$variant = VarInt::readUnsignedInt($in);
			$stackId = VarInt::readSignedInt($in);
		}else{
			$variant = 0;
			$stackId = 0;
		}

		$blockRuntimeId = VarInt::readUnsignedInt($in);
		$rawExtraData = CodecHelper::readString($in);
		return new ItemStackWrapper($stackId, new ItemStack($id, $meta, $count, $blockRuntimeId, $rawExtraData), $variant);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStackWrapper);

		LE::writeSignedShort($out, $data->itemStack->id);
		LE::writeUnsignedShort($out, $data->itemStack->count);
		VarInt::writeUnsignedInt($out, $data->itemStack->meta);

		CodecHelper::writeBool($out, $hasNetId = $data->stackId !== 0);
		if($hasNetId){
			VarInt::writeUnsignedInt($out, $data->stackIdVariant);
			VarInt::writeSignedInt($out, $data->stackId);
		}

		VarInt::writeUnsignedInt($out, $data->itemStack->blockRuntimeId);
		CodecHelper::writeString($out, $data->itemStack->rawExtraData);
	}
}
