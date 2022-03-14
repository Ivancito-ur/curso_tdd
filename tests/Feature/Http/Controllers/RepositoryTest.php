<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Repository;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use WithFaker, RefreshDatabase;


    public function test_index_empty()
    {
        Repository::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user)->get('repositories')->assertStatus(200)->assertSee('No hay repositorios creados.');
    }

    public function test_index_with_data()
    {
        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user)->get('repositories')->assertStatus(200)->assertSee($repository->id)->assertSee($repository->url);
    }


    public function test_guest()
    {
        $this->get('repositories')->assertRedirect('login'); //Si voy a al link: .../repositories y no 
        //estoy logeado que se vaya para login

        $this->get('repositories/1')->assertRedirect('login'); //obtener uno
        $this->get('repositories/1/edit')->assertRedirect('login'); //obtener la informacion editar
        $this->put('repositories/1')->assertRedirect('login'); //enviar la edición
        $this->delete('repositories/1')->assertRedirect('login'); //eliminar
        $this->post('repositories', [])->assertRedirect('login'); // salvar

    }

    public function test_create()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
        ->get('repositories/create')
        ->assertStatus(200); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }


    public function test_store()
    {
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,

        ];

        $user = User::factory()->create();

        $this->actingAs($user)->post('repositories', $data)->assertRedirect('repositories'); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.

        $this->assertDatabaseHas('repositories', $data);
    }
    public function test_update()
    {
        $user = User::factory()->create();

        $repository = Repository::factory()->create(['user_id' => $user->id]);
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,

        ];


        $this->actingAs($user)->put("repositories/$repository->id", $data)->assertRedirect("repositories/$repository->id/edit"); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.

        $this->assertDatabaseHas('repositories', $data);
    }

    public function test_update_policy()
    {
        $user = User::factory()->create(); //Tiene el id = 1

        $repository = Repository::factory()->create(); // Tiene el id = 2
        $data = [
            'url' => $this->faker->url,
            'description' => $this->faker->text,

        ];

        $this->actingAs($user)->put("repositories/$repository->id", $data)->assertStatus(403); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }

    public function test_store_validate()
    {
        $data = [];

        $user = User::factory()->create();

        $this->actingAs($user)->post('repositories', $data)->assertStatus(302)->assertSessionHasErrors(['url', 'description']); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.

    }

    public function test_update_validate()
    {

        $repository = Repository::factory()->create();
        $data = [];

        $user = User::factory()->create();

        $this->actingAs($user)->put("repositories/$repository->id", $data)->assertStatus(302)->assertSessionHasErrors(['url', 'description']); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.

    }

    public function test_destroy()
    {

        $user = User::factory()->create();
        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete("repositories/$repository->id")->assertRedirect("repositories"); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.

        $this->assertDatabaseMissing('repositories', [
            'id' => $repository->id,
            'url' => $repository->url,
            'description' => $repository->description,
        ]);
    }

    public function test_destroy_policy()
    {
        $user = User::factory()->create(); //Id = 1

        $repository = Repository::factory()->create(); //ID =2

        $this->actingAs($user)->delete("repositories/$repository->id",)->assertStatus(403); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }

    public function test_show()
    {
        $user = User::factory()->create();

        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->get("repositories/$repository->id")->assertStatus(200); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }


    public function test_show_policy()
    {
        $user = User::factory()->create(); //Tiene el id = 1

        $repository = Repository::factory()->create(); // Tiene el id = 2

        $this->actingAs($user)->get("repositories/$repository->id")->assertStatus(403); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }

    public function test_edit()
    {
        $user = User::factory()->create();

        $repository = Repository::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
        ->get("repositories/$repository->id/edit")
        ->assertStatus(200)
        ->assertSee($repository->url)
        ->assertSee($repository->description); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }


    public function test_edit_policy()
    {
        $user = User::factory()->create(); //Tiene el id = 1

        $repository = Repository::factory()->create(); // Tiene el id = 2

        $this->actingAs($user)->get("repositories/$repository->id/edit")->assertStatus(403); //Esto es para que el test tenga un usuario autenticado, entonces si queremos que todos funcionen, hacemos que este nuevo usuario
        //actue como uno real.
    }



}
