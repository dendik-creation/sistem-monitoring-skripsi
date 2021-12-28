<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlotDosbingModel extends Model
{
    protected $table = 'plot_dosbing';
    protected $fillable = ['smt', 'nim', 'name', 'dosbing1', 'dosbing2'];
    public $timestamps = false;
}
