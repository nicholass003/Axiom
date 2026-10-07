<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Packet;

use Nicholass003\Axiom\Data\PacketRecipient;
use Nicholass003\Axiom\Data\Type\AttributeLayerSyncPayload;

class ClientboundAttributeLayerSyncPacket implements Packet{

    public const ID = PacketIds::CLIENTBOUND_ATTRIBUTE_LAYER_SYNC;
    public const RECIPIENT = PacketRecipient::CLIENT;

    public AttributeLayerSyncPayload $payload;
}
