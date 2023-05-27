<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
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
        Contact::factory()->create();
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
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('contacts.show',['contact'=>$contact->id]));

        $response->assertSee($contact->name);
        $response->assertSee($contact->contact);
        $response->assertSee($contact->email);
    }

    public function test_should_not_show_contact_details_if_not_logged_in()
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.show',['contact'=>$contact->id]));

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    /* STORE CONTACT TESTS */

    public function test_should_not_allow_to_store_names_with_less_than_5_characters()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route(
            'contacts.store',
            Contact::factory()->make(['name' => 'abcd'])->toArray()
        ));
        $response->assertRedirect();
        $response->assertSessionHasErrors('name');
    }

    public function test_should_not_allow_to_store_contacts_without_exacly_9_characters()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->make(['contact' => $faker->regexify('[0-9]{8}')])->toArray()
           );
        $response->assertRedirect();
        $response->assertSessionHasErrors('contact');

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->make(['contact' => $faker->regexify('[0-9]{10}')])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('contact');
    }

    public function test_should_not_allow_to_store_email_with_invalid_patterns()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->make(['email' => $faker->word])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->make(['email' => $faker->word.'@'])->toArray()
        );
        $response->assertRedirect();
        $response->assertSessionHasErrors('email');

        $response = $this->actingAs($user)->post(route('contacts.store'),
            Contact::factory()->make(['email' => $faker->word.$faker->word])->toArray()
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
        $response->assertSessionHas(['success'=>'Contact saved successfully']);
    }

    /*UPDATE CONTACT TESTS*/

    public function test_should_not_allow_to_see_edit_page_if_not_logged_in()
    {
        $contact = Contact::factory()->create();
        $response = $this->get(route('contacts.show',['contact'=>$contact->id]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(Session::get('error'),'You must be logged in to view this page');
    }

    public function test_should_show_edit_page()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $response = $this->actingAs($user)->post(route('contacts.show',['contact'=>$contact->id]));
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee($user->contact);
        $response->assertSee('Update Contact');
    }

    public function test_should_update_contact_with_valid_data()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $newContactData = Contact::factory()->make();

        $response = $this->actingAs($user)->put(route('contacts.update', $contact->id), $newContactData->toArray());

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Contact updated successfully');
        $this->assertDatabaseHas('contacts',$newContactData->toArray());
    }

    public function test_should_not_update_contact_with_less_than_5_characters()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $newContactData = Contact::factory()->make(['name'=>'a']);

        $response = $this->actingAs($user)->put(route('contacts.update', $contact), $newContactData->toArray());

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('contacts', [
            'id' => $newContactData->id,
            'name' => $newContactData->name,
            'email' => $newContactData->email,
            'contact' => $newContactData->contact,
        ]);

        $newContactData = Contact::factory()->make(['name'=>'ab']);
        $response = $this->actingAs($user)->put(route('contacts.update', $contact), $newContactData->toArray());

        $response->assertRedirect()->assertSessionHasErrors('name');
        $this->assertDatabaseMissing('contacts', [
            'id' => $newContactData->id,
            'name' => $newContactData->name,
            'email' => $newContactData->email,
            'contact' => $newContactData->contact,
        ]);

        $newContactData = Contact::factory()->make(['name'=>'abc']);

        $response = $this->actingAs($user)->put(route('contacts.update', $contact), $newContactData->toArray());

        $response->assertRedirect()->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('contacts', [
            'id' => $newContactData->id,
            'name' => $newContactData->name,
            'email' => $newContactData->email,
            'contact' => $newContactData->contact,
        ]);

        $newContactData = Contact::factory()->make(['name'=>'abcd']);

        $response = $this->actingAs($user)->put(route('contacts.update', $contact), $newContactData->toArray());

        $response->assertRedirect()->assertSessionHasErrors('name');

        $this->assertDatabaseMissing('contacts', [
            'id' => $newContactData->id,
            'name' => $newContactData->name,
            'email' => $newContactData->email,
            'contact' => $newContactData->contact,
        ]);

    }

    public function test_should_not_update_contact_without_exacly_9_characters()
    {
        $faker = \Faker\Factory::create();
        $user = User::factory()->create();

        for($i = 1; $i < 9; $i++){
            $contact = Contact::factory()->make(['contact' => $faker->regexify('[0-9]{'.$i.'}')])->toArray();

            $response = $this->actingAs($user)->post(route('contacts.store'),$contact);
            $response->assertRedirect();
            $response->assertSessionHasErrors('contact');

            $this->assertDatabaseMissing('contacts', $contact);
        }

        $contact = Contact::factory()->make(['contact' => $faker->regexify('[0-9]{10}')])->toArray();
        $response = $this->actingAs($user)->post(route('contacts.store'),$contact);

        $this->assertDatabaseMissing('contacts', $contact);
        $response->assertRedirect();
        $response->assertSessionHasErrors('contact');
    }

    public function test_should_soft_delete_contact()
    {
        $user = User::factory()->create();
        $contact = Contact::factory()->create();
        $response = $this->actingAs($user)->delete(route('contacts.destroy', $contact->id));
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Contact deleted successfully');
        $this->assertSoftDeleted($contact);
    }

    public function test_should_not_delete_contact_if_not_logged_in()
    {
        $contact = Contact::factory()->create();
        $response = $this->delete(route('contacts.destroy', $contact->id));
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(Session::get('error'),'You must be logged in to delete contacts');
        $this->assertNotSoftDeleted($contact);
    }


}
