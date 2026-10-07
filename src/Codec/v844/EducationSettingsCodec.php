<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\v844;

use Nicholass003\Axiom\Codec\Codec;
use Nicholass003\Axiom\Codec\CodecHelper;
use Nicholass003\Axiom\Codec\CodecType;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsAgentCapabilities;
use Nicholass003\Axiom\Data\Type\Education\EducationSettingsExternalLinkSettings;
use Nicholass003\Axiom\Packet\EducationSettingsPacket;
use Nicholass003\Axiom\Packet\Packet;
use pmmp\encoding\ByteBufferReader;
use pmmp\encoding\ByteBufferWriter;

class EducationSettingsCodec implements Codec{

    public function decode(ByteBufferReader $in, CodecType $codec) : EducationSettingsPacket{
        $pk = new EducationSettingsPacket();
        $pk->codeBuilderDefaultUri = CodecHelper::readString($in);
        $pk->codeBuilderTitle = CodecHelper::readString($in);
        $pk->canResizeCodeBuilder = CodecHelper::readBool($in);
        $pk->disableLegacyTitleBar = CodecHelper::readBool($in);
        $pk->postProcessFilter = CodecHelper::readString($in);
        $pk->screenshotBorderResourcePath = CodecHelper::readString($in);
        $pk->agentCapabilities = CodecHelper::readOptional($in, fn($i) => $codec->read(EducationSettingsAgentCapabilities::class, $i));
        $pk->codeBuilderOverrideUri = CodecHelper::readOptional($in, fn($i) => CodecHelper::readString($i));
        $pk->hasQuiz = CodecHelper::readBool($in);
        $pk->linkSettings = CodecHelper::readOptional($in, fn($i) => $codec->read(EducationSettingsExternalLinkSettings::class, $i));
        return $pk;
    }

    public function encode(ByteBufferWriter $out, Packet $pk, CodecType $codec) : void{
        assert($pk instanceof EducationSettingsPacket);
        CodecHelper::writeString($out, $pk->codeBuilderDefaultUri);
        CodecHelper::writeString($out, $pk->codeBuilderTitle);
        CodecHelper::writeBool($out, $pk->canResizeCodeBuilder);
        CodecHelper::writeBool($out, $pk->disableLegacyTitleBar);
        CodecHelper::writeString($out, $pk->postProcessFilter);
        CodecHelper::writeString($out, $pk->screenshotBorderResourcePath);
        CodecHelper::writeOptional($out, $pk->agentCapabilities, fn($o, $v) => $codec->write(EducationSettingsAgentCapabilities::class, $o, $v));
        CodecHelper::writeOptional($out, $pk->codeBuilderOverrideUri, fn($o, $v) => CodecHelper::writeString($o, $v));
        CodecHelper::writeBool($out, $pk->hasQuiz);
        CodecHelper::writeOptional($out, $pk->linkSettings, fn($o, $v) => $codec->write(EducationSettingsExternalLinkSettings::class, $o, $v));
    }
}
