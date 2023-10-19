<?php

namespace App\Enums;

/**
 * Available values for project and task statuses
 */
enum ProjectStatus: string
{
    case NEW = 'new';
    case PENDING = 'pending';
    case FAILED = 'failed';
    case DONE = 'done';
}
