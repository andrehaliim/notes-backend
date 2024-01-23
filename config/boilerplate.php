<?php

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

return [
    'user_login' => [
        'validation_rules' => [
            'username' => 'required|string',
            'password' => 'required|string',
        ]
    ],

    'user_create' => [
      'validation_rules' => [
          'nik' => 'nullable|string|unique:users,nik',
          'name' => 'required|string',
          'email' => 'required|email',
          'role' => 'required|string',
          'is_active' => 'boolean'
      ]
    ],

    'user_update' => [
      'validation_rules' => [
          'nik' => 'nullable|string',
          'name' => 'nullable|string',
          'email' => 'required|email',
          'role' => 'required|string',
          'is_active' => 'boolean',
      ]
    ]
];
