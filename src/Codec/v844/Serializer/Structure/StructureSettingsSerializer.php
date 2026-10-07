<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Structure;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Structure\StructureSettings;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;
use pmmp\encoding\VarInt;

class StructureSettingsSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : StructureSettings{
		return new StructureSettings(
			paletteName: CodecHelper::readString($in),
			ignoreEntities: CodecHelper::readBool($in),
			ignoreBlocks: CodecHelper::readBool($in),
			allowNonTickingChunks: CodecHelper::readBool($in),
			dimensions: CodecHelper::readBlockPosition($in),
			offset: CodecHelper::readBlockPosition($in),
			lastTouchedByPlayerID: VarInt::readSignedInt($in),
			rotation: VarInt::readUnsignedInt($in),
			mirror: VarInt::readUnsignedInt($in),
			animationMode: VarInt::readUnsignedInt($in),
			animationSeconds: LE::readFloat($in),
			integrityValue: LE::readFloat($in),
			integritySeed: LE::readUnsignedInt($in),
			pivot: CodecHelper::readVec3($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof StructureSettings);

		CodecHelper::writeString($out, $data->paletteName);
		CodecHelper::writeBool($out, $data->ignoreEntities);
		CodecHelper::writeBool($out, $data->ignoreBlocks);
		CodecHelper::writeBool($out, $data->allowNonTickingChunks);
		CodecHelper::writeBlockPosition($out, $data->dimensions);
		CodecHelper::writeBlockPosition($out, $data->offset);
		VarInt::writeSignedInt($out, $data->lastTouchedByPlayerID);
		VarInt::writeUnsignedInt($out, $data->rotation);
		VarInt::writeUnsignedInt($out, $data->mirror);
		VarInt::writeUnsignedInt($out, $data->animationMode);
		LE::writeFloat($out, $data->animationSeconds);
		LE::writeFloat($out, $data->integrityValue);
		LE::writeUnsignedInt($out, $data->integritySeed);
		CodecHelper::writeVec3($out, $data->pivot);
	}
}
