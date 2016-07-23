<?php
namespace App\Model;
use Chatbox\Token\Storage\Eloquent\Eloquent;

/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/07/18
 * Time: 19:11
 */
class AuthTokenTable extends Eloquent
{
    protected $table = "rt_auth_token";
}