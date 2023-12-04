<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [];

        foreach (range(1, 10) as $index) {
            $company = [
                'name' => $name = "Company $index",
                'address' => "Address $name",
                'website' => "Website $name",
                'email' => "Email $name",
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $companies[] = $company;
        }

        DB::table('companies')->delete();  // deletes all rows from 'users'
        DB::table('companies')->insert($companies);  // inserts seeder data into 'users'
    }
}
