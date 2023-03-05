<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class RolePermission extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $table = 'role_has_permissions';

    protected $dates = ['deleted_at'];
}
