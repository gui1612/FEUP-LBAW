<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumOwners extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'forumowners';

    public function forum()
    {
        return $this->belongsTo(Forum::class, 'forum_id');
    }

    public function owners()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function getForumOwnerName(int $id)
    {
        $user = User::find($id);
        return $user->username;
    }
}
