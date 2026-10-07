<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v1001\Serializer;

use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Codec\SerializerInterface;
use Nicholass003\Axiom\Codec\Support\StatelessForkable;
use Nicholass003\Axiom\Data\Type\WhiskerScopeDataSummary;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class WhiskerScopeDataSummarySerializer implements SerializerInterface{
    use StatelessForkable;

    public function read(ByteBufferReader $in, CodecType $codec) : WhiskerScopeDataSummary{
        return new WhiskerScopeDataSummary(
            label: CodecHelper::readString($in),
            identation: CodecHelper::readString($in),
            totalHighCostNS: LE::readUnsignedLong($in),
            totalMidCostNS: LE::readUnsignedLong($in),
            totalLowCostNS: LE::readUnsignedLong($in)
        );
    }

    public function write(ByteBufferWriter $out, mixed $data, CodecType $codec) : void{
        assert($data instanceof WhiskerScopeDataSummary);

        CodecHelper::writeString($out, $data->label);
        CodecHelper::writeString($out, $data->identation);
        LE::writeUnsignedLong($out, $data->totalHighCostNS);
        LE::writeUnsignedLong($out, $data->totalMidCostNS);
        LE::writeUnsignedLong($out, $data->totalLowCostNS);
    }
}
