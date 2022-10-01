<?php

namespace Jabu\Task\Domain\Enums;

use Illuminate\Support\Str;

trait HasTitleValues
{
    public function getValue(): string
    {
        return Str::title(str_replace('_', ' ', $this->value));
    }
}
