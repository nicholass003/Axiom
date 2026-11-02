<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ItemStack;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class ItemStackSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ItemStack{
        $id = VarInt::readSignedInt($in);
        $count = LE::readUnsignedShort($in);
        $meta = VarInt::readUnsignedInt($in);
        $blockRuntimeId = VarInt::readSignedInt($in);
        $rawExtraData = CodecHelper::readString($in);
        return new ItemStack($id, $meta, $count, $blockRuntimeId, $rawExtraData);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ItemStack);

        VarInt::writeSignedInt($out, $data->id);
        LE::writeUnsignedShort($out, $data->count);
        VarInt::writeUnsignedInt($out, $data->meta);
        VarInt::writeSignedInt($out, $data->blockRuntimeId);
        CodecHelper::writeString($out, $data->rawExtraData);
	}
}
