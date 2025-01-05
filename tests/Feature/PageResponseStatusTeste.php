<?php

test('testando codigo 200')
    ->get('/')
    ->assertStatus(200)
    ->assertOk();

test('testando o codigo 404')
    ->get('/404')
    ->assertStatus(404)
    ->assertNotFound();

test('testando codigo 403:: nao tem permissao de acesso')
    ->get('/403')
    ->assertStatus(403)
    ->assertForbidden();
