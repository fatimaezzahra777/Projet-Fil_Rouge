<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $response = $this->post('/register', [
        'nom' => 'User',
        'prenom' => 'Test',
        'telephone' => '0612345678',
        'ville' => 'Casablanca',
        'genre' => 'Femme',
        'date_naissance' => '1998-05-10',
        'role' => 'patient',
        'type_addiction' => 'Tabac',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});
