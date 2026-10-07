<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\MetadataEntry;
use Nicholass003\Axiom\Enum\MetadataPropertyType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class MetadataEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : MetadataEntry{
        $id = VarInt::readUnsignedInt($in);
        $type = MetadataPropertyType::safe(VarInt::readUnsignedInt($in));
        $value = match($type){
            MetadataPropertyType::BYTE => Byte::readSigned($in),
            MetadataPropertyType::SHORT => LE::readSignedShort($in),
            MetadataPropertyType::INT => VarInt::readSignedInt($in),
            MetadataPropertyType::FLOAT => LE::readFloat($in),
            MetadataPropertyType::STRING => CodecHelper::readString($in),
            MetadataPropertyType::COMPOUND_TAG => CodecHelper::readNbt($in),
            MetadataPropertyType::BLOCK_POS => CodecHelper::readSignedBlockPosition($in),
            MetadataPropertyType::LONG => VarInt::readSignedLong($in),
            MetadataPropertyType::VEC3 => CodecHelper::readVec3($in),
            default => throw new \RuntimeException("Unknown metadata type")
        };
        return new MetadataEntry($id, $type, $value);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof MetadataEntry);

        VarInt::writeUnsignedInt($out, $data->id);
        VarInt::writeUnsignedInt($out, $data->type->value);
        match($data->type){
            MetadataPropertyType::BYTE => Byte::writeSigned($out, $data->value),
            MetadataPropertyType::SHORT => LE::writeSignedShort($out, $data->value),
            MetadataPropertyType::INT => VarInt::writeSignedInt($out, $data->value),
            MetadataPropertyType::FLOAT => LE::writeFloat($out, $data->value),
            MetadataPropertyType::STRING => CodecHelper::writeString($out, $data->value),
            MetadataPropertyType::COMPOUND_TAG => CodecHelper::writeNbt($out, $data->value),
            MetadataPropertyType::BLOCK_POS => CodecHelper::writeSignedBlockPosition($out, $data->value),
            MetadataPropertyType::LONG => VarInt::writeSignedLong($out, $data->value),
            MetadataPropertyType::VEC3 => CodecHelper::writeVec3($out, $data->value),
            default => throw new \RuntimeException("Unknown metadata type")
        };
	}
}
