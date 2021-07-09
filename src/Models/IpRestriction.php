<?php


namespace Devzone\UserManagement\Models;


use Illuminate\Database\Eloquent\Model;

class IpRestriction extends Model
{
    protected $table = 'ip_whitelists';
    protected $guarded = [];
}
