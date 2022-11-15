<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model 
{ 
  
  public $timestamps = false;

  protected $table = 'reports';

  public function reported() {
    return $this->belongsTo(User::class);
  }

  public function reporter() {
    return $this->belongsTo(User::class);
  }

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function forumReported() {
    return $this->belongsTo(Forum::class);
  }

}





