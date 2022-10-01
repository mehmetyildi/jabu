<?php

namespace Jabu\Task\Domain\Enums;

enum RecurrenceType : string
{
    use HasTitleValues;
    use HasCaseValues;

    case INTERVAL = 'interval';
    case NUMBER_OF_TIMES = 'number_of_times';
}
