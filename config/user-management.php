<?php

return [
    'prefix' => 'ums',
    'middleware' => ['web'],
    'link_user_account' => true,
    // Permission sections hidden from the user/role permission screens. Set in the app's published config, e.g. ['examination'].
    'hidden_sections' => [],
];
