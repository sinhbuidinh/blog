<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create(['name' => 'Jonathan Reinink', 'email' => 'jonathan@reinink.ca']);
        factory(App\Models\User::class)->create(['name' => 'Taylor Otwell', 'email' => 'taylor@laravel.com']);
        factory(App\Models\User::class)->create(['name' => 'Ian Landsman', 'email' => 'ian@userscape.com', 'is_admin' => true]);

        factory(App\Models\Customer::class, 200)->create()->each(function ($customer) {
            $customer->update([
                'company_id' => factory(App\Models\Company::class)->create()->id,
                'sales_rep_id' => random_int(1, 2),
            ]);

            $customer->interactions()->saveMany(factory(App\Models\Interaction::class, 10)->make());
        });
    }
}
