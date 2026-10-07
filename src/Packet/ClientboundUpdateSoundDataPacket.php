<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\Sound\SoundDataEvent;
use Nicholass003\Axiom\Enum\SoundEventType;

/** @since v1001 */
class ClientboundUpdateSoundDataPacket implements Packet{

    public const ID = PacketIds::CLIENTBOUND_UPDATE_SOUND_DATA;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public int $serverSoundHandle = 0;

    /** @deprecated v2168 */
    public SoundEventType $soundEvent = SoundEventType::STOP;

    /** @since v2168 */
    public ?SoundDataEvent $stopEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $volumeEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $pitchEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $fadeEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $seekToEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $pauseEvent = null;
    /** @since v2168 */
    public ?SoundDataEvent $resumeEvent = null;
}
