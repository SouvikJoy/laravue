<?php

namespace Database\Seeders;

use App\Models\SiteOption;
use Illuminate\Database\Seeder;

class SiteOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteOption::updateOrCreate([
            'title'      => 'app-name'
        ], [
            'content' => 'Debugger Tech',
            'type'    => 'text'
        ]);

        SiteOption::updateOrCreate([
            'title'      => 'app-description'
        ], [
            'content' => '',
            'type'    => 'text'
        ]);

        SiteOption::updateOrCreate([
            'title'      => 'app-keywords'
        ], [
            'content' => '',
            'type'    => 'text'
        ]);

        SiteOption::updateOrCreate([
            'title'      => 'main-address'
        ], [
            'content' => '',
            'type'    => 'text'
        ]);

        SiteOption::updateOrCreate([
            'title'      => 'main-email'
        ], [
            'content' => '',
            'type'    => 'text'
        ]);

        SiteOption::updateOrCreate([
            'title'      => 'main-phone'
        ], [
            'content' => '',
            'type'    => 'text'
        ]);
    }
}
