<?php
/**
 * Customize for Shop loop product
 */
return [
    [
        'type' => 'section',
        'name' => 'zoo_contact',
        'title' => esc_html__('Contact', 'ciao'),
    ],
    [
        'name' => 'zoo_contact_general_settings',
        'type' => 'heading',
        'label' => esc_html__('Contact Settings', 'ciao'),
        'section' => 'zoo_contact',
    ],
    [
        'name' => 'zoo_contact_type',
        'type' => 'select',
        'section' => 'zoo_contact',
        'title' => esc_html__('Contact Type', 'ciao'),
        'default' => 'none',
        'choices' => [
            'none' => esc_html__('None', 'ciao'),
            'phone' => esc_html__('Phone', 'ciao'),
            'email' => esc_html__('Email', 'ciao'),
            'messenger' => esc_html__('Messenger', 'ciao'),
            'whatsapp' => esc_html__('Whatsapp', 'ciao'),
            'skype' => esc_html__('Skype', 'ciao'),
        ]
    ],
    [
        'type' => 'text',
        'name' => 'zoo_contact_id',
        'label' => esc_html__('Contact ID', 'ciao'),
        'section' => 'zoo_contact',
        'description' => esc_html__('Your contact id. That is your phone, email or social id follow type contact you selected', 'ciao'),
        'required' => ['zoo_contact_type', '!=', 'none'],
    ],
];
