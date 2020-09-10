<?php

namespace Core\Precons;

use Core\Http\Request;
use Core\Http\Response;

class CSRFPrecon implements Precon {

  public function validate(Request $request) {
    if(!app('session')->get('x-token')) {
      return Response::error(Response::INTERNAL_SERVER_ERROR, 'CSRF token not set!');
    }

    $token = $request->get('x-token');

    if($token === null || $token !== app('session')->get('x-token')) {
      return Response::error(Response::UNAUTHORIZED);
    }

    return $request;
  }
}