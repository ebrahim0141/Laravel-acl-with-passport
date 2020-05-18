<?php

namespace App\Model\ActivityLog;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = "activity_logs";
    protected $fillable = ['action_type', 'request_url', 'os', 'browser', 'robot', 'device', 'ip', 'controller', 'user_id', 'error_code', 'status_code', 'response_message', 'response_data'];
}
