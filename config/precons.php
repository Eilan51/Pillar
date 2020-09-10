<?php

use Core\Precons\AuthPrecon;
use Core\Precons\GuestPrecon;
use Core\Precons\CSRFPrecon;

return [
  'auth' => AuthPrecon::class,
  'guest' => GuestPrecon::class,
  'csrf' => CSRFPrecon::class,
];

