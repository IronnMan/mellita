<?php

namespace Mellita\SaaS\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $key, string $value1, string $value2 = null)
 */
class Tenant extends Model
{
    use HasDateTimeFormatter;

    public $incrementing = false;
}
