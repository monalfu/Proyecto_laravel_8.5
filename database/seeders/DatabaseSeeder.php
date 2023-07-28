<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Noticia;
use App\Models\Comentario;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(30)->create();
        Noticia::factory(30)->create();
        Comentario::factory(40)->create();
    }
}
