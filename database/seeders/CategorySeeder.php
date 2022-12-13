<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategoriData = [
            [
                'nama_kategori' => 'Kering',
            ],
            [
                'nama_kategori' => 'Basah'
            ],
        ];

        foreach ($kategoriData as $key => $val) {
            Kategori::create($val);
        }
    }
}