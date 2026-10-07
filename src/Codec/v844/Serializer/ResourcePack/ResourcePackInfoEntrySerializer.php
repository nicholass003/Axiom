<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844\Serializer\ResourcePack;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\ResourcePack\ResourcePackInfoEntry;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ResourcePackInfoEntrySerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : ResourcePackInfoEntry{
		return new ResourcePackInfoEntry(
			packId: CodecHelper::readUUID($in),
			version: CodecHelper::readString($in),
			sizeBytes: LE::readUnsignedLong($in),
			encryptionKey: CodecHelper::readString($in),
			subPackName: CodecHelper::readString($in),
			contentId: CodecHelper::readString($in),
			hasScripts: CodecHelper::readBool($in),
			isAddonPack: CodecHelper::readBool($in),
			isRtxCapable: CodecHelper::readBool($in),
			cdnUrl: CodecHelper::readString($in)
		);
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof ResourcePackInfoEntry);

		CodecHelper::writeUUID($out, $data->packId);
		CodecHelper::writeString($out, $data->version);
		LE::writeUnsignedLong($out, $data->sizeBytes);
		CodecHelper::writeString($out, $data->encryptionKey);
		CodecHelper::writeString($out, $data->subPackName);
		CodecHelper::writeString($out, $data->contentId);
		CodecHelper::writeBool($out, $data->hasScripts);
		CodecHelper::writeBool($out, $data->isAddonPack);
		CodecHelper::writeBool($out, $data->isRtxCapable);
		CodecHelper::writeString($out, $data->cdnUrl);
	}
}
