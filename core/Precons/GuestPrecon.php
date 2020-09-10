<?php

namespace Core\Precons;

use Core\Http\Request;
use Core\Http\Response;

class GuestPrecon implements Precon {

  public function validate(Request $request) {
    if(app('session')->get('user_id') !== null) {
      return Response::redirect(back());
    }

    return $request;
  }
}