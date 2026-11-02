<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;

class P0MandatoryDeliverablesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * P0: Public home route returns 200 and renders contact email.
     */
    public function test_public_home_route_renders_successfully_with_contact_email(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('nixresponding@gmail.com');
        $response->assertSee('mailto:nixresponding@gmail.com', false);
    }

    /**
     * P0: Public documentation route returns 200 and renders contact email.
     */
    public function test_public_docs_route_renders_successfully_with_contact_email(): void
    {
        $response = $this->get('/docs');

        $response->assertStatus(200);
        $response->assertSee('nixresponding@gmail.com');
        $response->assertSee('mailto:nixresponding@gmail.com', false);
        $response->assertSee('TicketingSlotInterface');
    }

    /**
     * P0: Demo login persona picker route returns 200.
     */
    public function test_demo_login_route_renders_successfully(): void
    {
        $response = $this->get('/demo/login');

        $response->assertStatus(200);
        $response->assertSee('Elena Vance');
        $response->assertSee('Marcus Sterling');
        $response->assertSee('Aria Chen');
    }

    /**
     * P0: Quick login for Visitor Member persona.
     */
    public function test_quick_login_visitor_member_persona(): void
    {
        $response = $this->post('/demo/quick-login', [
            'persona_key' => 'visitor_member',
        ]);

        $response->assertRedirect(route('movies.index'));
        $this->assertAuthenticated();
        $this->assertEquals('elena.vance@demo.matinee.test', auth()->user()->email);
        $this->assertEquals('visitor_member', auth()->user()->role);
    }

    /**
     * P0: Quick login for Cinema Manager persona redirects to backoffice.
     */
    public function test_quick_login_cinema_manager_persona(): void
    {
        $response = $this->post('/demo/quick-login', [
            'persona_key' => 'cinema_manager',
        ]);

        $response->assertRedirect(route('manage.cinemas.index'));
        $this->assertAuthenticated();
        $this->assertEquals('marcus.sterling@demo.matinee.test', auth()->user()->email);
        $this->assertEquals('cinema_manager', auth()->user()->role);
    }

    /**
     * P0: Quick login for Platform Admin persona redirects to backoffice.
     */
    public function test_quick_login_platform_admin_persona(): void
    {
        $response = $this->post('/demo/quick-login', [
            'persona_key' => 'platform_admin',
        ]);

        $response->assertRedirect(route('manage.dashboard'));
        $this->assertAuthenticated();
        $this->assertEquals('aria.chen@demo.matinee.test', auth()->user()->email);
        $this->assertEquals('platform_admin', auth()->user()->role);
    }

    /**
     * P0: Logout route clears authentication and redirects to demo login.
     */
    public function test_logout_clears_authentication(): void
    {
        $user = User::where('role', 'visitor_member')->first();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect(route('demo.login'));
        $this->assertGuest();
    }
}
