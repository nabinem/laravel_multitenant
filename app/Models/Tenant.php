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

        //only for file cache driver
        $cacheFolder = storage_path('framework/cache/data/'.$this->domain);
        if (!file_exists($cacheFolder)) mkdir($cacheFolder);
        
        config([
            'database.connections.tenant.database' => $this->database,
            'session.files' => $sessionFolder,
            'cache.stores.file.path' => $cacheFolder,
            'cache.prefix' => $this->id,
        ]);

        DB::purge('tenant');

        app('cache')->purge(config('cache.default'));

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
