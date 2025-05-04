<?php

//namespace App\Models;

//use Illuminate\Database\Eloquent\Model;

//class pets extends Model
//{
    //
//}





namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pets extends Model
{

    protected $guarded  = ['id'];

    public function adoption()
    {
        return $this->hasOne(Adoption::class,'pet_id');
    }

}
