<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v2168;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\EntityDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\MemoryCategoryCounter;
use Nicholass003\Axiom\Data\Type\SystemCategory;
use Nicholass003\Axiom\Data\Type\SystemDiagnosticTimingInfo;
use Nicholass003\Axiom\Data\Type\WhiskerScopeDataSummary;
use Nicholass003\Axiom\Packet\Packet;
use Nicholass003\Axiom\Packet\ServerboundDiagnosticsPacket;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;
use pmmp\encoding\LE;

class ServerboundDiagnosticsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : ServerboundDiagnosticsPacket{
        $pk = new ServerboundDiagnosticsPacket();

        $pk->avgFps = LE::readFloat($in);
        $pk->avgServerSimTickTimeMS = LE::readFloat($in);
        $pk->avgClientSimTickTimeMS = LE::readFloat($in);
        $pk->avgBeginFrameTimeMS = LE::readFloat($in);
        $pk->avgInputTimeMS = LE::readFloat($in);
        $pk->avgRenderTimeMS = LE::readFloat($in);
        $pk->avgEndFrameTimeMS = LE::readFloat($in);
        $pk->avgRemainderTimePercent = LE::readFloat($in);
        $pk->avgUnaccountedTimePercent = LE::readFloat($in);

        $pk->memoryCategoryValues = CodecHelper::readList($in, fn($in) => $codec->read(MemoryCategoryCounter::class, $in));
        $pk->entityDiagnostics = CodecHelper::readList($in, fn($in) => $codec->read(EntityDiagnosticTimingInfo::class, $in));
        $pk->systemDiagnostics = CodecHelper::readList($in, fn($in) => $codec->read(SystemDiagnosticTimingInfo::class, $in));
        $pk->systemCategories = CodecHelper::readList($in, fn($in) => $codec->read(SystemCategory::class, $in));
        $pk->whiskerScopes = CodecHelper::readList($in, fn($in) => $codec->read(WhiskerScopeDataSummary::class, $in));

        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof ServerboundDiagnosticsPacket);
        LE::writeFloat($out, $pk->avgFps);
        LE::writeFloat($out, $pk->avgServerSimTickTimeMS);
        LE::writeFloat($out, $pk->avgClientSimTickTimeMS);
        LE::writeFloat($out, $pk->avgBeginFrameTimeMS);
        LE::writeFloat($out, $pk->avgInputTimeMS);
        LE::writeFloat($out, $pk->avgRenderTimeMS);
        LE::writeFloat($out, $pk->avgEndFrameTimeMS);
        LE::writeFloat($out, $pk->avgRemainderTimePercent);
        LE::writeFloat($out, $pk->avgUnaccountedTimePercent);

        CodecHelper::writeList($out, $pk->memoryCategoryValues, fn($out, $v) => $codec->write(MemoryCategoryCounter::class, $out, $v));
        CodecHelper::writeList($out, $pk->entityDiagnostics, fn($out, $v) => $codec->write(EntityDiagnosticTimingInfo::class, $out, $v));
        CodecHelper::writeList($out, $pk->systemDiagnostics, fn($out, $v) => $codec->write(SystemDiagnosticTimingInfo::class, $out, $v));
        CodecHelper::writeList($out, $pk->systemCategories, fn($out, $v) => $codec->write(SystemCategory::class, $out, $v));
        CodecHelper::writeList($out, $pk->whiskerScopes, fn($out, $v) => $codec->write(WhiskerScopeDataSummary::class, $out, $v));
    }
}
