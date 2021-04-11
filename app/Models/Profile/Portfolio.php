<?php

namespace App\Models\Profile;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Portfolio
 * @package App\Models\Profile
 * @property int $id
 * @property string $title
 * @property float $sum
 * @property bool $hide
 * @property bool $deleted
 * @property int $user_id
 */
class Portfolio extends Model
{
    /** @var array  */
    protected $fillable = ['title', 'sum', 'hide'];
}