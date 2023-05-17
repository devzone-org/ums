<?php


namespace Devzone\UserManagement\Console;


use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
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
        Permission::updateOrCreate(['name' => '1.edit-profile-photo'], ['guard_name' => 'web', 'description' => 'edit profile photo', 'portal' => 'user management', 'section' => 'user management']);
        Permission::updateOrCreate(['name' => '1.change-users-passwords'], ['guard_name' => 'web', 'description' => 'change users passwords', 'portal' => 'user management', 'section' => 'user management']);

        User::updateOrCreate([
            'email' => 'talha@devzone.services'
        ], [
            'name' => 'Muhammad Talha',
            'password' => Hash::make('HelloWorld123@#'),
            'status' => 't',
            'account_id' => '78',
            'account_name' => 'Cash in Hand - Muhammad Talha'
        ]);
        $user = User::find(1);
        foreach (Permission::get() as $permission) {
            if ($user->email == 'talha@devzone.services') {
                $user->givePermissionTo($permission->name);
            }
        }
        $this->info('Dumping  Master Data UMS...');
    }
}
