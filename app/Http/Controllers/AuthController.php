<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Entities\User;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * AuthController constructor.
     * @param AuthService $authService
     *
     * Injecting the class AuthService in the class constructor.
     * Laravel Container, part of the Dependency inject framework in instantiating
     * the class for us
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): array
    {
        /** validating only the types */
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
        ]);

        return $this->authService->login($request->email, $request->password);
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return $this->authService->user();
    }
}
