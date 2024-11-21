<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case Cash = 'cash';
    case Debit = 'debit';
    case EWallet = 'e-wallet';
}
