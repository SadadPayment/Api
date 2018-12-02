<?php

use Illuminate\Database\Seeder;

class UsersTableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->User();
        $this->AgentUser();

    }

    private function AgentUser()
    {
        DB::table('agents')->insert([
            'first_name' => 'Elteyab',
            'last_name' => 'Ali',
            'phone' => '0917321783',
            'email' => 'altyab@sadad-pay.com',
            'work' => 'Sadad Payment',
            'state' => 'الخرطوم',
            'city' => "الخرطوم شرق",
            'local' => "الجريف غرب",
            'address' => "الجريف غرب مربع 84",
            'latitude' => "15.4444",
            'longitude' => "32.4322",
            'password' => Hash::make('123456')
        ]);
    }

    private function User()
    {
        $user = new App\User();
        $user->username = 'ox';
        $user->fullName = 'elteyab hassan';
        $user->email = 'admin@gmail.com';
        $user->phone = '0917321783';
        $user->password = Hash::make('123456');
        $user->user_group = '1';
        $user->status = '1';
        $user->save();
        App\Model\Account\BankAccount::saveBankAccountByUser(
            '9888061010278131317',
            '0000', '1812',
            0, 1);

    }
}
