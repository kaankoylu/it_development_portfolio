<?php

namespace Tests\Feature;

use App\Models\Biography;
use App\Models\CourseProgress;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioFeatureTest extends TestCase
{
    use RefreshDatabase; // this one resets database state between tests

    protected function setUp(): void
    {
        parent::setUp();

        // setting up base bio context required by index/api paths
        Biography::create([
            'full_name' => 'Test Engineer',
            'title' => 'QA Professional',
            'bio_text' => 'Testing suite coverage matrix.',
            'skills' => 'PHP, Laravel'
        ]);
    }

    /** @test */
    public function public_visitor_can_view_homepage_and_see_only_published_posts()
    {
        Post::create(['title' => 'Draft Post', 'content' => '...', 'status' => 'draft']);
        Post::create(['title' => 'Published Post', 'content' => '...', 'status' => 'published']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Published Post');
        $response->assertDontSee('Draft Post');
    }

    /** @test */
    public function anonymous_visitor_cannot_access_owner_dashboard_owasp_a01()
    {
        // Unauthenticated access attempt should turn me back back to login
        $response = $this->get('/owner/dashboard');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function unauthorized_registered_user_cannot_access_owner_dashboard_owasp_a01()
    {
        // User who is NOT admin@gmail.com attempts access
        $regularUser = User::factory()->create(['email' => 'visitor@guest.com']);

        $response = $this->actingAs($regularUser)->get('/owner/dashboard');
        $response->assertStatus(403); // forbidden
    }

    /** @test */
    public function authenticated_owner_can_access_dashboard_and_manage_workflows()
    {
        $owner = User::factory()->create(['email' => 'admin@showcase.com']);

        $response = $this->actingAs($owner)->get('/owner/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Portfolio Control Console');
    }

    /** @test */
    public function owner_can_create_a_new_blog_post_via_form()
    {
        $owner = User::factory()->create(['email' => 'admin@showcase.com']);

        $response = $this->actingAs($owner)->post('/owner/posts', [
            'title' => 'Pipeline Expansion Article',
            'content' => 'Comprehensive integration metrics analysis.',
            'status' => 'published'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', ['title' => 'Pipeline Expansion Article']);
    }

    /** @test  FOR APIs*/
    public function client_side_rest_api_endpoints_return_correct_json_structures()
    {
        CourseProgress::create([
            'course_name' => 'Automated Integration Testing',
            'credits_ec' => 5,
            'status' => 'completed'
        ]);

        // Test Endpoint 1
        $responseStats = $this->getJson('/api/v1/stats');
        $responseStats->assertStatus(200)
            ->assertJsonStructure(['meta' => ['system_time', 'status'], 'data' => ['total_ec_achieved']]);

        // Test Endpoint 2
        $responseProfile = $this->getJson('/api/v1/profile');
        $responseProfile->assertStatus(200)
            ->assertJsonFragment(['name' => 'Test Engineer']);
    }
}
