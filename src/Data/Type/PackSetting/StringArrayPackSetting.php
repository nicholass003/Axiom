<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Data\Type\PackSetting;

final class StringArrayPackSetting extends PackSetting{

    /** @var list<string> */
    public array $value;

    /**
     * @param string[] $value
     * @phpstan-param list<string> $value
     */
    public function __construct(string $name, array $value){
        parent::__construct($name);
        $this->value = $value;
    }

    /**
     * @return list<string>
     */
    public function getValue() : array{
        return $this->value;
    }
}
