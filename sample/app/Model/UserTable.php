<?php
/**
 * Created by PhpStorm.
 * User: mkkn
 * Date: 2016/07/18
 * Time: 19:14
 */

namespace App\Model;


use Chatbox\ApiAuth\Models\User;
use Chatbox\Token\Storage\Migratable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

class UserTable extends User implements Migratable
{
    protected $table = "rt_user";

    protected $fillable = [
        "name","email","password"
    ];


    protected function _whereByCredential($credential)
    {
        return $this->where([
            "email" => $credential["email"],
            "password" => $this->hashPassword($credential["password"])
        ]);
    }

    protected function createSaveData($data):array
    {
        $data["password"] = $this->hashPassword($data["password"]);
        return $data;
    }

    protected function hashPassword($password){
        return sha1($password);
    }


    public function upTable(Builder $builder)
    {
        $builder->create($this->table,function(Blueprint $table){
            $table->increments("id");
            $table->string("name");
            $table->string("email");
            $table->string("password");
            $table->timestamps();
        });
    }

    public function downTable(Builder $builder)
    {
        $builder->dropIfExists($this->table);
    }


}