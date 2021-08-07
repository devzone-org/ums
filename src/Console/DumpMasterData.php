<?php


namespace Devzone\UserManagement\Console;


use Illuminate\Console\Command;
use Spatie\Permission\Models\Permission;

class DumpMasterData extends Command
{
    protected $signature = 'ums:master-data';

    protected $description = 'Dumping master data for ums';

    public function handle()
    {
        Permission::updateOrCreate(['name' => '1.user.list'], ['guard_name' => 'web', 'description' => 'user list', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.user.create'], ['guard_name' => 'web', 'description' => 'user create', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.user.link-accounts'], ['guard_name' => 'web', 'description' => 'user link to accounts', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.user-edit'], ['guard_name' => 'web', 'description' => 'user edit', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.user-schedule'], ['guard_name' => 'web', 'description' => 'user schedule', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.user-permission'], ['guard_name' => 'web', 'description' => 'user permissions', 'portal' => 'user management', 'section' => 'user management']);

        $this->info('Dumping  Master Data UMS...');
    }
}
