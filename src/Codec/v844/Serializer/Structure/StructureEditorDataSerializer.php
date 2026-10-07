<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\Structure;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Structure\StructureEditorData;
use Nicholass003\Axiom\Data\Type\Structure\StructureSettings;
use Nicholass003\Axiom\Enum\StructureBlockType;
use pmmp\encoding\Byte;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\VarInt;

class StructureEditorDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : StructureEditorData{
		return new StructureEditorData(
			structureName: CodecHelper::readString($in),
			filteredStructureName: CodecHelper::readString($in),
			structureDataField: CodecHelper::readString($in),
			includePlayers: CodecHelper::readBool($in),
			showBoundingBox: CodecHelper::readBool($in),
			structureBlockType: StructureBlockType::safe(VarInt::readUnsignedInt($in)),
			structureSettings: $codec->read(StructureSettings::class, $in),
			structureRedstoneSaveMode: Byte::readUnsigned($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof StructureEditorData);

		CodecHelper::writeString($out, $data->structureName);
		CodecHelper::writeString($out, $data->filteredStructureName);
		CodecHelper::writeString($out, $data->structureDataField);
		CodecHelper::writeBool($out, $data->includePlayers);
		CodecHelper::writeBool($out, $data->showBoundingBox);
		VarInt::writeUnsignedInt($out, $data->structureBlockType->value);
		$codec->write(StructureSettings::class, $out, $data->structureSettings);
		Byte::writeUnsigned($out, $data->structureRedstoneSaveMode);
	}
}
