<?php

return [
    'prefix' => 'ums',
    'middleware' => ['web'],
    'link_user_account' => true,
    // Comma-separated permission sections hidden from the user/role permission screens, e.g. UMS_HIDDEN_SECTIONS="examination,transport"
    'hidden_sections' => array_values(array_filter(array_map('trim', explode(',', (string) env('UMS_HIDDEN_SECTIONS', ''))))),
];
