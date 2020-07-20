<?php

namespace App\Services;

use App\Entities\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthService
 * @package App\Services
 *
 * All the logic and rules should go inside services
 * This layer should not use $_SESSION,$_GET,$_POST,$_SERVER,$_REQUEST
 */
class AuthService
{
    public function login(string $email, string $password): array
    {
        /**
         * Here we are validating that is mandatory for the login
         */
        $this->validate(['email' => $email,'password' => $password], [
            'email' => 'email',
            'password' => 'min:6'
        ]);

        if ($email !== 'marcelo.nakash@gmail.com' || md5($password) !== md5('123456')) {
            throw new UnauthorizedHttpException('jwt-auth', 'User not found');
        }

        return ['access_token' => base64_encode($email)];
    }

    /**
     * @return User
     */
    public function user(): User
    {
        return new User('marcelo.nakash@gmail.com', 'Marcelo Nakashima', '123456');
    }

    /**
     * @param Request $request
     */
    public function authenticate(Request $request)
    {
        if ($request->header('Authorization') != 'Bearer '.base64_encode('marcelo.nakash@gmail.com')) {
            throw new UnauthorizedHttpException('jwt-auth', 'User not found');
        }
    }

    /**
     * @param array $data
     * @param array $rules
     * @throws ValidationException
     */
    private function validate(array $data, array $rules) :void
    {
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->messages());
        }
    }
}
