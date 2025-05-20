<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table = 'historylog';
    public $timestamps = false;

    protected $fillable = [
        'note_desc',
        'filename',
        'ip_info',
        'users_id',
        'logtype_id'
    ];
    // This function is used to create a new activity log entry
    public function createLog($data)
    {
        return $this->create($data);
    }
    // This function is used to get all activity logs
    public function getAllLogs()
    {
        return $this->all();
    }
    // This function is used to test the creation of a new activity log entry
    public function testCreateLog()
    {
        $data = [
            'note_desc' => 'Test log entry',
            'filename' => 'testfile.txt',
            'ip_info' => '23232',
            'users_id' => 1,
            'logtype_id' => 1
        ];
        $log = $this->createLog($data);
        return $log;
    }
}
