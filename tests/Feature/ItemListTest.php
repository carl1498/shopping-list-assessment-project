<?php

use App\Models\Department;
use App\Models\User;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;

test('has item list index', function () {

    $this->actingAs($user = User::factory()->create());

    $response = $this->get(route('list.index'));

    $response->assertStatus(200);
});

test('an item list can be created', function () {
    $this->actingAs($user = User::factory()->create());

    $item = Item::factory()->create();

    $input = [
        "item_id" => $item->id,
        "quantity" => 2
    ];

    $response = $this->post(route('list.store'), $input);

    $response->assertRedirect(route('list.index'));
    
    $this->assertDatabaseHas( 'item_list', [
        'item_id' => $item->id,
        'quantity' => 2,
    ] );
});
