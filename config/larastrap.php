<?php

return [
    /*
        Overwrite this to use a custom prefix for Blade's components in your
        template. For example, defining it as "ls" you can include any component
        as in <x-ls::input />
    */
    'prefix' => 'ls',

    /*
        Lower level of configuration: those parameters are applied to all
        elements, and overwritten by the below array "elements" or by inline
        attributes (that have precedence on every other)
    */
    'commons' => [
        'label_width' => '2',
        'input_width' => '10',
    ],

    /*
        Configuration for specific elements: feel free to overwrite them as
        preferred.
        Many of them are already defined as defaults within the specific
        elements and provided here just for convenience
    */
    'elements' => [
        'navbar' => [
            'color' => 'light',
        ],

        'modal' => [
            'buttons' => [
                ['color' => 'secondary', 'label' => 'Close', 'attributes' => ['data-bs-dismiss' => 'modal']]
            ],
        ],

        'form' => [
            'formview' => 'horizontal',
            'method' => 'POST',

            'buttons' => [
                ['color' => 'primary', 'label' => 'Save', 'attributes' => ['type' => 'submit']]
            ]
        ],

        'field' => [
            'margins' => [0, 0, 3, 0],
        ],

        'radios' => [
            'color' => 'outline-primary',
        ],

        'checks' => [
            'color' => 'outline-primary',
        ],

        'tabs' => [
            'tabview' => 'tabs',
        ],

        'tabpane' => [
            'classes' => ['p-3']
        ]
    ],

    /*
        Examples of Custom Elements.
        Feel free to remove them, or customize as you like.
        For further details, read the documentation:
        https://larastrap.madbob.org/docs/custom-elements/overview
    */

    'customs' => [
        'badge' => [
            'extends' => 't',
            'params' => [
                'node' => 'span',
                'classes' => ['badge', 'text-bg-secondary'],
            ],
        ],

        'alert' => [
            'extends' => 't',
            'params' => [
                'node' => 'div',
                'classes' => ['alert', 'alert-info'],
            ],
        ],

        'spinner' => [
            'extends' => 't',
            'params' => [
                'node' => 'div',
                'classes' => ['spinner-border'],
                'attributes' => [
                    'role' => 'status',
                ],
                'innerPrependNodes' => [
                    'extends' => 't',
                    'params' => [
                        'node' => 'span',
                        'classes' => ['visually-hidden'],
                        'content' => 'Loading...',
                    ],
                ],
            ],
        ],

        'card' => [
            'extends' => 'composite',
            'params' => [
                'node' => 'div',
                'classes' => ['card'],
                'prependNodes' => [
                    [
                        'extends' => 't',
                        'params' => [
                            'node' => 'div',
                            'classes' => ['card-header'],
                            'contentfrom' => 'header'
                        ]
                    ],
                    [
                        'extends' => 't',
                        'params' => [
                            'node' => 'div',
                            'classes' => ['card-body'],
                            'innerAppendNodes' => [
                                '$slot'
                            ]
                        ]
                    ]
                ]
            ]
        ],


    ],
];
