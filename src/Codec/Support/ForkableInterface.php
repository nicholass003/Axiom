<?php

declare(strict_types=1);

namespace Nicholass003\Axiom\Codec\Support;

interface ForkableInterface{

    public function fork() : static;
}
