<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        if (User::count() === 0) {
            User::create([
                'name'               => 'Thisath Geemal',
                'email'              => 'thisathgeemal38@gmail.com',
                'password'           => '123456789',
                'mobile_number'      => '0701733646',
                'address'            => 'No 1, Admin Street, Colombo',
                'gender'             => 'male',
                'dob'                => '2005-01-01',
                'user_roles'         => ['super_admin', 'admin'],
                'is_active'          => true,
                'profile_photo_path' => null,
            ]);

            User::create([
                'name'               => 'Ravindu Bandara',
                'email'              => 'goldenstay2007@gmail.com',
                'password'           => '123456789',
                'mobile_number'      => '0701733646',
                'address'            => 'No 1, Admin Street, Colombo',
                'gender'             => 'male',
                'dob'                => '2006-01-01',
                'user_roles'         => ['admin'],
                'is_active'          => true,
                'profile_photo_path' => null,
            ]);

            User::create([
                'name'               => 'Sankalpa Withanaarachchi',
                'email'              => 'withanaarachchisankalpa16@gmail.com',
                'password'           => '123456789',
                'mobile_number'      => '0701733646',
                'address'            => 'No 1, Admin Street, Colombo',
                'gender'             => 'male',
                'dob'                => '2004-01-01',
                'user_roles'         => ['member'],
                'is_active'          => true,
                'profile_photo_path' => null,
            ]);

            User::create([
                'name'               => 'Nikila Nirmal',
                'email'              => 'nikilanirmal16@gmail.com',
                'password'           => '123456789',
                'mobile_number'      => '0701733646',
                'address'            => 'No 1, Admin Street, Colombo',
                'gender'             => 'male',
                'dob'                => '2001-01-01',
                'user_roles'         => ['agent'],
                'is_active'          => true,
                'profile_photo_path' => null,
            ]);

            User::create([
                'name'               => 'Lakindu Hasaranga',
                'email'              => 'lakindusudaraka@gmail.com',
                'password'           => '123456789',
                'mobile_number'      => '0701733646',
                'address'            => 'No 1, Admin Street, Colombo',
                'gender'             => 'male',
                'dob'                => '2005-01-01',
                'user_roles'         => ['agent', 'member'],
                'is_active'          => true,
                'profile_photo_path' => null,
            ]);
        }
    }
}
