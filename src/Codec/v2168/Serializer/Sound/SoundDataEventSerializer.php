<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168\Serializer\Sound;

use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\Sound\SoundDataEvent;
use Nicholass003\Axiom\Enum\SoundDataEventType;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class SoundDataEventSerializer implements SerializerInterface{
	use StatelessForkable;

	public function read(ByteBufferReader $in, CodecType $codec) : SoundDataEvent{
		$type = SoundDataEventType::from(LE::readUnsignedInt($in));

		return match($type){
			SoundDataEventType::STOP => new SoundDataEvent(type: $type),
			SoundDataEventType::SET_VOLUME => new SoundDataEvent(type: $type, volume: LE::readFloat($in)),
			SoundDataEventType::SET_PITCH => new SoundDataEvent(type: $type, pitch: LE::readFloat($in)),
			SoundDataEventType::FADE => new SoundDataEvent(
				type: $type,
				duration: LE::readFloat($in),
				targetVolume: LE::readFloat($in)
			),
			SoundDataEventType::SEEK_TO => new SoundDataEvent(type: $type, seconds: LE::readFloat($in)),
			SoundDataEventType::PAUSE => new SoundDataEvent(type: $type),
			SoundDataEventType::RESUME => new SoundDataEvent(type: $type),
		};
	}

	public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
		assert($data instanceof SoundDataEvent);

		LE::writeUnsignedInt($out, $data->type->value);

		match($data->type){
			SoundDataEventType::SET_VOLUME => LE::writeFloat($out, $data->volume ?? 0.0),
			SoundDataEventType::SET_PITCH => LE::writeFloat($out, $data->pitch ?? 0.0),
			SoundDataEventType::FADE => (function() use ($out, $data) : void{
				LE::writeFloat($out, $data->duration ?? 0.0);
				LE::writeFloat($out, $data->targetVolume ?? 0.0);
			})(),
			SoundDataEventType::SEEK_TO => LE::writeFloat($out, $data->seconds ?? 0.0),
			default => null,
		};
	}
}
