<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v898\Serializer\Command;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Command\CommandOverloadRawData;
use Nicholass003\Axiom\Data\Type\Command\CommandRawData;
use Nicholass003\Axiom\Enum\CommandPermissions;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class CommandDataSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : CommandRawData{
		return new CommandRawData(
			name: CodecHelper::readString($in),
			description: CodecHelper::readString($in),
			flags: LE::readUnsignedShort($in),
			permission: CommandPermissions::fromString(CodecHelper::readString($in)),
			aliasEnumIndex: LE::readSignedInt($in),
			chainedSubCommandDataIndexes: CodecHelper::readList($in, fn($in) => LE::readUnsignedShort($in)),
			overloads: CodecHelper::readList($in, fn($in) => $codec->read(CommandOverloadRawData::class, $in))
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof CommandRawData);

		CodecHelper::writeString($out, $data->name);
		CodecHelper::writeString($out, $data->description);
		LE::writeUnsignedShort($out, $data->flags);
		CodecHelper::writeString($out, $data->permission->toString());
		LE::writeSignedInt($out, $data->aliasEnumIndex);

		CodecHelper::writeList($out, $data->chainedSubCommandDataIndexes, fn($out, $idx) => LE::writeUnsignedShort($out, $idx));
		CodecHelper::writeList($out, $data->overloads, fn($out, $v) => $codec->write(CommandOverloadRawData::class, $out, $v));
	}
}
