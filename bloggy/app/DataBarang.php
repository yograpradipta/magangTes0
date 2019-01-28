<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataBarang extends Model
{
    protected $table= 'databarang';
    protected $fillable=['nama_barang','jumlah'];

}
