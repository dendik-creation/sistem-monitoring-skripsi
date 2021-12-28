<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $fillable = ['nim', 'name'];
}
