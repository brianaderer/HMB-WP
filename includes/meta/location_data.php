<?php

function register_location_data_meta() {
    register_post_meta('post', 'location_data', [
        'type'         => 'object',
        'single'       => true,
        'show_in_rest' => [
            'schema' => [
                'type'  => 'object',
                'properties' => [
                    'place_id' => [
                        'type' => 'string',
                        'default' => '',
                    ],
                    'geodesic' => [
                        'type' => 'object',
                        'properties' => [
                            'distance' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                        ],
                    ],
                    'foot' => [
                        'type' => 'object',
                        'properties' => [
                            'duration' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                            'distance' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                        ],
                    ],
                    'car' => [
                        'type' => 'object',
                        'properties' => [
                            'duration' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                            'distance' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                        ],
                    ],
                    'bike' => [
                        'type' => 'object',
                        'properties' => [
                            'duration' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                            'distance' => [
                                'type' => 'object',
                                'properties' => [
                                    'value' => ['type' => 'number'],
                                    'text'  => ['type' => 'string'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'default' => [
            'place_id' => '',
            'geodesic' => [
                'distance' => [
                    'value' => 0,
                    'text'  => '',
                ],
            ],
            'foot' => [
                'duration' => [
                    'value' => 0,
                    'text'  => '',
                ],
                'distance' => [
                    'value' => 0,
                    'text'  => '',
                ],
            ],
            'car' => [
                'duration' => [
                    'value' => 0,
                    'text'  => '',
                ],
                'distance' => [
                    'value' => 0,
                    'text'  => '',
                ],
            ],
            'bike' => [
                'duration' => [
                    'value' => 0,
                    'text'  => '',
                ],
                'distance' => [
                    'value' => 0,
                    'text'  => '',
                ],
            ],
        ],
        'sanitize_callback' => 'sanitize_location_data',
        'auth_callback'     => function() {
            return current_user_can('edit_posts');
        },
    ]);
}

function sanitize_location_data($value) {
    if (!is_array($value)) {
        return [];
    }

    $modes = ['geodesic', 'foot', 'car', 'bike'];
    foreach ($modes as $mode) {
        if (isset($value[$mode]) && is_array($value[$mode])) {
            foreach (['distance', 'duration'] as $property) {
                if (isset($value[$mode][$property]) && is_array($value[$mode][$property])) {
                    $value[$mode][$property]['value'] = isset($value[$mode][$property]['value']) ? floatval($value[$mode][$property]['value']) : 0;
                    $value[$mode][$property]['text']  = isset($value[$mode][$property]['text']) ? sanitize_text_field($value[$mode][$property]['text']) : '';
                } else {
                    $value[$mode][$property] = ['value' => 0, 'text' => ''];
                }
            }
        } else {
            $value[$mode] = [
                'distance' => ['value' => 0, 'text' => ''],
                'duration' => ['value' => 0, 'text' => ''],
            ];
        }
    }

    return $value;
}

add_action('init', 'register_location_data_meta');
