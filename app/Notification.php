<?php

namespace App;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    public function scopeUnread($query)
    {
    	return $query->where('read_at',null);
    }
}
