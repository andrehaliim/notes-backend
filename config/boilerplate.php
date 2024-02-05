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
          'username' => 'required|string|unique:users,username',
          'name' => 'required|string',
          'email' => 'required|email',
          'role' => 'required|string',
          'is_active' => 'boolean'
      ]
    ],

    'user_update' => [
      'validation_rules' => [
          'name' => 'nullable|string',
          'email' => 'nullable|email',
          'role' => 'nullable|string',
          'is_active' => 'boolean',
      ]
      ],

    'notes_create' => [
      'validation_rules' => [
        'user_id' => 'required|numeric|exists:users,id',
        'title' => 'required|string',
        'text' => 'required|string'
      ]
    ],

    'notes_update' => [
      'validation_rules' => [
        'title' => 'required|string',
        'text' => 'required|string'
      ]
    ]
    
];
