<?php

namespace Jabu\Task\Domain\Enums;

enum Timeframe : string
{
    use HasCaseValues;
    use HasTitleValues;

    case ALL = 'all';
    case TODAY = 'today';
    case THIS_WEEK = 'this_week';
    case NEXT_WEEK = 'next_week';
    case FUTURE = 'future';
}
