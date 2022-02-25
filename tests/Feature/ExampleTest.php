<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {

         $this->postJson('api/auth/register',[
             'name' => 'name',
             'email' => 'email@gmail.com',
             'password' =>'password',
             'password_confirmation' =>'password',
         ])->assertSuccessful()->assertJson(
             [
                 'data'=> [
                     'name' => 'name',
                     'email' => 'email',
                     'password' =>'password',

                 ],
             ],

         );

    }

    public function test_user_can_login()
    {

        $this->postJson('api/auth/login',[
            'email' => 'email@gmail.com',
            'password' =>'password',
        ])->assertJson([
            'data'=> [
                'email' => 'email',
                'password' =>'password',

            ],
            'meta'=>[
                'token'=>''
            ]
        ])->assertSuccessful();

    }
}
