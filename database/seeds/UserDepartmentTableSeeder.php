<?php

use App\{User, Department};
use Illuminate\Database\Seeder;

class UserDepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = User::pluck('id')->toArray();
        $departmentIds = Department::pluck('id')->toArray();

        $userDepartments = [];

        foreach ($userIds as $id){
            $userDepartment['user_id'] = $id;
            $userDepartment['department_id'] = array_random($departmentIds);

            $userDepartments[] = $userDepartment;

        }

        DB::table('user_department')->insert($userDepartments);
    }
}
