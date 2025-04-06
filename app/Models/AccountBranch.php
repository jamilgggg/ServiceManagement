<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountBranch extends Model
{
    use HasFactory;
    protected $table = 'sp_account_branch';
    public $timestamps = true;
}
