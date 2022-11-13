<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model 
{ 
  public $timestamps = false;

  protected $table = 'reports';

  function reported() {
    return $this->belongsTo(User::class);
  }

  function reporter() {
    return $this->belongsTo(User::class);
  }
}





