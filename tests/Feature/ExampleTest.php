<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('returns a successful response', function (): void {
    $response = $this->get('/');

    $response->assertOk();
});
