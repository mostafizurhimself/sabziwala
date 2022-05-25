<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $userResources = [
            // web
            \App\Models\Product::class,
            \App\Models\Review::class,
            \App\Models\Category::class,
            \App\Models\Zone::class,
            \App\Models\Customer::class,
            \App\Models\Rider::class,
            \App\Models\Employee::class,

            \App\Models\Order::class,
            \App\Models\RefundRequest::class,

            \App\Models\Expense::class,
            \App\Models\ExpenseType::class,
            \App\Models\Loan::class,
            \App\Models\Salary::class,

            \App\Models\Role::class,
            \App\Models\User::class,
            \App\Models\Contact::class,

            \App\Models\Appearance::class,

            \App\Models\Settings::class,
            \App\Models\Country::class,
            \App\Models\Unit::class,
            \App\Models\Contact::class,
        ];

        foreach ($userResources as $key => $model) {
            $name     = $model::readableName();
            $order    = 1;

            // CreateOrUpdate permission group
            $group = PermissionGroup::updateOrCreate(['name' => $name, 'guard_name' => 'web'], ['name' => $name, 'order' => $order, 'guard_name' => 'web']);
            foreach ($model::$permissions as $permission) {
                $name = $permission . "-" . $model::readableName();
                Permission::updateOrCreate(['name' => $name], ['group_id' => $group->id, 'name' => $name, 'order' => ($order), 'guard_name' => 'web']);
                $order++;
            }
        }

        $superAdmin = Role::updateOrCreate(['name' => Role::SUPER_ADMIN, 'guard_name' => 'web'], ['name' => Role::SUPER_ADMIN, 'guard_name' => 'web']);
        $superAdmin->givePermissionTo(Permission::where('guard_name', 'web')->get());
    }
}
