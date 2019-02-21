<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class CrudTest extends TestCase
{
    protected $table;
    protected $baseUri;
    protected $dataCreate;
    protected $dataUpdate;
    protected $dataCheck;

    public function testlogin()
    {
        $email = readline('Email Correct: ');
        $password = readline('Password Correct: ');
        $user = factory(User::class)->make([
            'email' => $email,
            'password' => bcrypt($password),
        ]);
        $this->from('/admin/login')->post('/admin/login', [
            'email' => $user->email,
            'password' => $password,
        ])->assertStatus(302);
        $code = readline('2fa Code: ');
        $this->from('/admin')->post('/2fa', [
            'one_time_password' => $code
        ])->assertStatus(302);
    }

    public function testCreate()
    {
        $this->testlogin();
        $this->get('/admin/' . $this->baseUri)->assertStatus(200);
        $this->from('/admin/' . $this->baseUri)->post('admin/' . $this->baseUri, $this->dataCreate)->assertStatus(302);
        $this->assertDatabaseHas($this->table, $this->dataCheck);
    }

    public function testUpdate($model)
    {
        $this->testlogin();
        $this->get('/admin/' . $this->baseUri . '/' . $model->id . 'edit')->assertStatus(200);
        $this->dataUpdate['_method'] = 'PUT';
        $this->from('/admin/' . $this->baseUri . '/' . $model->id . 'edit')->post('/admin/' . $this->baseUri . '/' . $model->id, $this->dataUpdate)->assertStatus(302);
        $this->assertDatabaseHas($this->table, $this->dataCheck);
    }

    public function testShow($model, $viewShow)
    {
        $this->testlogin();
        $this->get('/admin/' . $this->baseUri . '/' . $model->id )->assertStatus(200)->assertViewIs($viewShow);
    }

    public function testDelete($model)
    {
        $this->testlogin();
        $this->get('/admin/' . $this->baseUri)->assertStatus(200);
        $this->from('/admin/' . $this->baseUri)->post('/admin/' . $this->baseUri . '/' . $model->id, ['_method' => 'DELETE'])->assertStatus(200);
        $this->assertDatabaseMissing($this->table, $this->dataCheck);
    }
}
