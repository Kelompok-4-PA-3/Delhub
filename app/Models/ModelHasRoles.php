<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Wildside\Userstamps\Userstamps;

class ModelHasRoles extends Model
{
    use HasFactory;
    use SoftDeletes;
    use UserStamps;

    protected $table = 'model_has_roles';

    protected $fillable = ['role_id', 'model_type', 'model_id'];
}
