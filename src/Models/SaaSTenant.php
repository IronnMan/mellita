<?php

namespace Mellita\SaaS\Models;

use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

/**
 * @method static create(array $array)
 */
class SaaSTenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
}
