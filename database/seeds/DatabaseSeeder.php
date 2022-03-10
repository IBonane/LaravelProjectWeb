<?php

use Illuminate\Database\Seeder;
use App\Repositories\Repository;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        touch('database/database.sqlite');

        $this->repository = new Repository();

        $this->repository->createDatabase();

        $this->repository->fillDatabase();
        
        $this->repository->updateRanking();

        $this->repository->addUser('user@exemple.com', 'secret');
        $this->repository->addUser('user@mail.com', 'secret1');

    }

}
