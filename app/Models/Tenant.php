<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

class Tenant extends Model
{
    use HasFactory;

    protected $connection = 'multitenant';

    protected $guarded = [];

    public function configure()
    {
        $sessionFolder = storage_path('framework/sessions/'.$this->domain);
        if (!file_exists($sessionFolder)) mkdir($sessionFolder);
        config([
            'database.connections.tenant.database' => $this->database,
            'session.files' => $sessionFolder,
        ]);

        DB::purge('tenant');

        DB::reconnect('tenant');

        Schema::connection('tenant')->getConnection()->reconnect();

        return $this;
    }

    /**
     *
     */
    public function use()
    {
        app()->forgetInstance('tenant');

        app()->instance('tenant', $this);

        return $this;
    }


}
