<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use DatabaseTransactions;

    /* INDEX CONTACT TESTS */
    public function test_should_see_index_page_with_contacts_table()
    {
        $contact = Contact::factory()->create();

        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee($contact->name);
    }

    public function test_should_see_create_page_button()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('Create Contact');
    }

    public function test_should_not_see_create_page_button_if_not_logged_in()
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertDontSee('Create Contact');
    }

    public function test_should_see_delete_contact_button()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('Delete Contact');
    }

    public function test_should_not_see_delete_contact_button_if_not_logged_in()
    {
        $response = $this->get('/');

        $response->assertStatus(Response::HTTP_OK);
        $response->assertDontSee('Delete Contact');
    }

    public function test_should_show_contact_details()
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.show',['contact'=>$contact->id]));

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee($contact->name);
        $response->assertSee($contact->contact);
        $response->assertSee($contact->email);
    }

    /* STORE CONTACT TESTS */

    public function test_should_not_allow_to_store_names_with_less_than_5_characters()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(
            route(
            'contacts.store',
             Contact::factory()->create(['name' => 'a'])->toArray()
            )
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('name');

        $response = $this->actingAs($user)->post(route(
            'contacts.store',
            Contact::factory()->create(['name' => 'ab'])->toArray()
        ));
        $response->assertRedirect();
        $response->assertSessionHasErrors('name');

        $response = $this->actingAs($user)->post(route(
            'contacts.store',
            Contact::factory()->create(['name' => 'abc'])->toArray()
        ));
        $response->assertRedirect();
        $response->assertSessionHasErrors('name');

        $response = $this->actingAs($user)->post(route(
            'contacts.store',
            Contact::factory()->create(['name' => 'abcd'])->toArray()
        ));
        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_should_not_allow_to_store_contacts_without_exacly_9_characters()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();

        for($i = 1; $i < 9; $i++){
            $response = $this->actingAs($user)->post(route('contacts.store'),[
                'name' => $faker->name,
                'contact' => $faker->regexify('[0-9]{'.$i.'}'),
                'email' => $faker->unique()->safeEmail(),
            ]);
            $response->assertRedirect();
            $response->assertSessionHasErrors('contact');
        }

        $response = $this->actingAs($user)->post(route('contacts.store'),[
            'name' => $faker->name,
            'contact' => $faker->regexify('[0-9]{10}'),
            'email' => $faker->unique()->safeEmail(),
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors('contact');
    }

    public function test_should_not_allow_to_store_email_with_invalid_patterns()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->create(['email' => $faker->word])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->create(['email' => $faker->word.'@'])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->create(['email' => $faker->word.$faker->word])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');
    }

    public function test_should_store_contact_with_valid_data()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('contacts.store'),Contact::factory()->make()->toArray());
        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $response->assertSee('Contact saved successfully');
    }


    /**/

}
