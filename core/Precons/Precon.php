<?php

namespace Core\Precons;

use Core\Http\Request;

interface Precon {
  public function validate(Request $request);
}