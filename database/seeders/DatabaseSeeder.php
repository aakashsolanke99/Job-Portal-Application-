<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Listing;
use \App\Models\User;
use \App\Models\Company;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create();
 
        // Create a company
        $company = Company::factory()->create();
     
        // Create listings and associate them with the created user and company
        Listing::factory(6)->create([
            'user_id' => $user->id,
            'company_id' => $company->id,  // Link the listing to the company
        ]);
     
        // Optionally create additional users
        User::factory()->count(10)->create();
       

        // \App\Models\Listing::create(
        // [
        
        //       'title' => 'Laravel Senior Developer', 
        
        //       'tags' => 'laravel, javascript',
        
        //       'company' => 'Acme Corp',
        
        //       'location' => 'Boston, MA',
        
        //       'email' => 'email1@email.com',
        
        //       'website' => 'https://www.acme.com',
        
        //       'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?'
        
        //   ]
        //  );

        // \App\Models\Listing::create([
        //     'title' => 'Full-Stack Engineer',
        //     'tags' => 'laravel, backend ,api',
        //     'company' => 'Stark Industries',
        //     'location' => 'New York, NY',
        //     'email' => 'email2@email.com',
        //     'website' => 'https://www.starkindustries.com',
        //     'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam minima et illo reprehenderit quas possimus voluptas repudiandae cum expedita, eveniet aliquid, quam illum quaerat consequatur! Expedita ab consectetur tenetur delensiti?'
        //   ]);

       
    }
}
