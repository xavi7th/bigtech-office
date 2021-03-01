<?php


return [
  // 'whitelist' => ['home', 'api.*'],
  /**
   * !Blacklist hidden routes from the general @routes call
   * ? Access the blacklisted routes using group routes
   * * @routes('auditor'), @routes(['auditor', 'superadmin]), @routes('*')
   */
  'blacklist' => ['debugbar.*', 'horizon.*', 'ignition.*', 'auditor.*', 'superadmin.*'],
  'groups' => [
    'auditor' => [
      'auditor.*'
    ],
    'accountant' => [
      'accountant.*'
    ],
    'qualitycontrol' => [
      'qualitycontrol.*'
    ],
    'salesrep' => [
      'salesrep.*'
    ],
    'webadmin' => [
      'webadmin.*'
    ],
    'superadmin' => [
      'superadmin.*',
      'auditor.*',
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
