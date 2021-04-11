<?php

namespace App\Swagger\Profile;

/**
 * Class Portfolio
 * @package App\Swagger\Profile
 *
 * @SWG\Definition(
 *  definition="ProfilePortfolio",
 * )
 */
class Portfolio
{
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    /**
     * @SWG\Property()
     * @var string
     */
    public $title;
    /**
     * @SWG\Property()
     * @var float
     */
    public $sum;
    /**
     * @SWG\Property()
     * @var string
     */
    public $currency;
    /**
     * @SWG\Property()
     * @var int
     */
    public $hide;
}