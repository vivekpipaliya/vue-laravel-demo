<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;

class MyFirstDuskTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function ($browser) {
            $browser->visit('/')
                    ->type('name', 'test')
                    ->type('email', 'test@gmail.com')
                    ->type('phone_number', '(123) 456-7890')
                    ->type('address', 'test')
                    ->type('zipcode', '12345')
                    ->attach('document', storage_path('app/public/testing/test-file.jpg'))
                    ->press('Execute')
                    ->assertPathIs('/api/submit');
        });
    }
}
