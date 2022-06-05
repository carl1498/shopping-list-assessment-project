<?php

use App\Models\Department;
use App\Models\User;
use Inertia\Testing\Assert;
use Inertia\Testing\AssertableInertia;


test('has items index', function () {

    $this->actingAs($user = User::factory()->create());

    $response = $this->get(route('items.index'));

    $response->assertStatus(200);
});

test('has items only show under users departments', function () {

    Item::factory(10)->create();
    Department::factory(5)->create();

    $user = User::factory()->create();
    $department = Department::factory()->for($user)->create();

    Item::factory(4)->for($department)->create();

    Department::factory(3)->for($user)->create();

    $this->assertCount( 13,  Item::all() );
    $this->assertCount( 6,  Department::all() );

    $this->actingAs($user);

    $response = $this->getJson(route('items.index'));
    $response->assertStatus(200);

    $this->assertCount( 4,  $response->json('items') );

    $response->assertStatus(200);
});

test('an item can be created', function () {
    $this->actingAs($user = User::factory()->create());

    $department = Department::factory()->create();

    $input = [
        "name" => 'item name',
        "department_id" => $department->id
    ];

    $response = $this->post(route('items.store'), $input);

    $response->assertRedirect(route('items.index'));
    
    $this->assertDatabaseHas( 'items', [
        'name' => 'item name',
        'department_id' => $department->id,
    ] );
});