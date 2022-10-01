<?php

namespace Jabu\Task\Domain\Enums;

enum Period : string
{
    use HasCaseValues;
    use HasTitleValues;

    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
}
