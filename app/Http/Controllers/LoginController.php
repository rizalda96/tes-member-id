<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function login(Request $request)
  {
    $query = $this->user->where('email', $request->email)->first();

    $type = $query ? 'success' : 'error';
    return $this->redirectResponse($request, $type, $type, $query);
  }
}
