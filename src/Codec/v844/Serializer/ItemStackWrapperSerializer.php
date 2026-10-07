<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

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
        $id = VarInt::readSignedInt($in);
        if($id === 0){
            return new ItemStackWrapper(0, new ItemStack(0, 0, 0, 0, ''));
        }
        $count = LE::readUnsignedShort($in);
        $meta = VarInt::readUnsignedInt($in);
        $hasNetId = CodecHelper::readBool($in);
        $stackId = $hasNetId ? CodecHelper::readServerItemStackId($in) : 0;
        $blockRuntimeId = VarInt::readSignedInt($in);
        $rawExtraData = CodecHelper::readString($in);
        return new ItemStackWrapper($stackId, new ItemStack($id, $meta, $count, $blockRuntimeId, $rawExtraData));
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof ItemStackWrapper);

        $item = $data->itemStack;
        if($item->id === 0){
            VarInt::writeSignedInt($out, 0);
            return;
        }
        VarInt::writeSignedInt($out, $item->id);
        LE::writeUnsignedShort($out, $item->count);
        VarInt::writeUnsignedInt($out, $item->meta);
        $hasNetId = $data->stackId !== 0;
        CodecHelper::writeBool($out, $hasNetId);
        if($hasNetId){
            CodecHelper::writeServerItemStackId($out, $data->stackId);
        }
        VarInt::writeSignedInt($out, $item->blockRuntimeId);
        CodecHelper::writeString($out, $item->rawExtraData);
    }
}
