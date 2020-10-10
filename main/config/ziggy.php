<?php


return [
  // 'whitelist' => ['home', 'api.*'],
  /**
   * !Blacklist hidden routes from the general @routes call
   * ? Access the blacklisted routes using group routes
   * * @routes('admin'), @routes(['admin', 'superadmin]), @routes('*')
   */
  'blacklist' => ['debugbar.*', 'horizon.*', 'ignition.*', 'admin.*', 'superadmin.*'],
  'groups' => [
    'admin' => [
      'admin.*'
    ],
    'accountant' => [
      'accountant.*'
    ],
    'dispatchadmin' => [
      'dispatchadmin.*'
    ],
    'qualitycontrol' => [
      'qualitycontrol.*'
    ],
    'salesrep' => [
      'salesrep.*'
    ],
    'stockkeeper' => [
      'stockkeeper.*'
    ],
    'webadmin' => [
      'webadmin.*'
    ],
    'superadmin' => [
      'superadmin.*',
      'admin.*',
      'appuser.*',
      'app.*',
    ],
    'appuser' => [
      'appuser.*'
    ],

    'multiaccess' => [
      'multiaccess.*',
    ],
     'public' => [
      'app.*',
    ],
    'auth' => [
      'app.login',
      'app.logout',
      'app.login.show'
    ],

  ],
];
