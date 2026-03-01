<?php

namespace App\Enum;


enum SmsMessageEnum: string
{
    case STATUS_PENDING = 'pending';
    case STATUS_SENT = 'sent';
    case STATUS_DELIVERED = 'delivered';
    case STATUS_FAILED = 'failed';
}
