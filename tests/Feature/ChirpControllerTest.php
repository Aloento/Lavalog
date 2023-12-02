<?php

namespace Tests\Feature;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ChirpControllerTest extends TestCase
{
  use RefreshDatabase;

  protected User $user;
  protected Chirp $chirp;

  public function setUp(): void
  {
    parent::setUp();

    $this->user = User::factory()->create();
    $this->chirp = Chirp::factory()->create([
      'user_id' => $this->user->id,
    ]);
  }

  public function testIndex()
  {
    $response = $this
      ->actingAs($this->user)
      ->get(route('chirps.index'));

    $response->assertOk();

    $response->assertInertia(fn(Assert $page) => $page
      ->component('Chirps')
      ->has('chirps', 1, fn(Assert $page) => $page
        ->where('id', $this->chirp->id)
        ->where('message', $this->chirp->message)
        ->has('user', fn(Assert $user) => $user
          ->where('id', $this->user->id)
          ->where('name', $this->user->name)
          ->etc()
        )
        ->etc()
      )
    );
  }
}
