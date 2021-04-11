<?php
/*
 * This file is part of the package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types=1);

namespace App\Core\Enum\Finance;


class Currency
{

    public const RUB = 'RUB';
    public const USD = 'USD';
    public const EUR = 'EUR';

    public const NUM = [
        self::RUB => 643,
        self::USD => 840,
        self::EUR => 978,
    ];

    public const DIVISION = [
        self::RUB => 4,
        self::USD => 4,
        self::EUR => 4,
    ];
}