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
        $user = new App\User();
        $user->username = 'ox';
        $user->fullName = 'elteyab hassan';
        $user->email = 'admin@gmail.com';
        $user->phone = '0917321783';
        $user->password =Hash::make('admin');
        $user->user_group='1';
        $user->status ='1';
        $user->save();
        App\Model\Account\BankAccount::saveBankAccountByUser('9888061010278131317', '0000', '1812', 0, 1);
    }
}
