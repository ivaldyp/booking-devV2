<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
	protected $primaryKey = 'id_bidang';

    protected $fillable = [
    	'id_subbidang', 'bidang_name', 'created_at', 'updated_at'
    ];

    // public function subbidang()
    // {
    //     return $this->hasOne('App\Subbidang','id_subbidang','id_subbidang');
    // }

    
}
