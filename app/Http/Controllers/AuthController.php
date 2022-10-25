<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/api/v1/auth/login",
     *   summary="Login ",
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/AuthenticationRequest")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=201,
     *      description="OK"
     *    ),
     *    @OA\Response(response=401, description="Authorization failed",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */
    public function login(Request $request)
    {
        $this->validate($request, \App\Requests\AuthenticationRequest::defaultValidatorRules());
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);

    }

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/api/v1/auth/register",
     *   summary="Register",
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/RegisterRequest")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=201,
     *      description="OK",
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/SuccessResponse"),
     *       },
     *      )
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */

    public function register(Request $request)
    {
        $this->validate($request, \App\Requests\RegisterRequest::defaultValidatorRules());

        $user = new User;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->display_name = $request->display_name;
        $user->status_id = 1;
        $user->save();

        $token = Auth::login($user);
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"Auth"},
     *   path="/api/v1/auth/logout",
     *   security={{ "apiAuth": {} }},
     *   summary="Logout",
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * @OA\Get(
     *   tags={"Auth"},
     *   path="/api/v1/auth/refresh",
     *   summary="Get new token",
     *   security={{ "apiAuth": {} }},
     *   @OA\Response(response=200, description="OK"),
     * )
     */
    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/api/v1/auth/change-password",
     *   summary="Change Password",
     *   security={{ "apiAuth": {} }},
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/ChangePasswordRequest")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=204,
     *      description="OK"
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */
    public function changePassword(Request $request)
    {
        $this->validate($request, \App\Requests\ChangePasswordRequest::defaultValidatorRules());
        $currentUser = Auth::user();
        $currentUser->makeVisible("password");
        $pwd = $currentUser->password;
        if (Hash::check($request->old_password, $currentUser->password)) {

            $currentUser->password = Hash::make($request->new_password);
            $currentUser->save();
            return response()->json(["message" => "Password changed."]);
        }

        return response()->json(["error" => "Old password is invalid"]);
    }

    /**
     * @OA\Patch(
     *   tags={"Auth"},
     *   path="/api/v1/auth/update-profile",
     *   summary="Update User profile",
     *   security={{ "apiAuth": {} }},
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *        allOf={
     *          @OA\Schema(ref="#/components/schemas/UpdateProfileRequest")
     *         }
     *      )
     *    ),
     *    @OA\Response(response=204,description="Updated"),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */
    public function updateProfile(Request $request)
    {

        $this->validate($request, \App\Requests\UpdateProfileRequest::defaultValidatorRules());
        $currentUser = Auth::user();
        if (request()->has("display_name")) {
            $currentUser->display_name = $request->display_name;
        }

        if (request()->has("email")) {
            $currentUser->email = $request->email;
        }

        $currentUser->save();
        return response(null, 204);

    }

    /**
     * @OA\Get(
     *   tags={"Auth"},
     *   path="/api/v1/auth/me",
     *   summary="Get current user profile",
     *   security={{ "apiAuth": {} }},
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/User"),
     *       }
     *      )
     *    ),
     *    @OA\Response(response=401, description="Anuthorized",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */
    public function me(Request $request)
    {
        $currentUser = Auth::user();
        return response()->json($currentUser);
    }

    /**
     * @OA\Post(
     *   tags={"Auth"},
     *   path="/api/v1/auth/check",
     *   summary="Check authentication token",
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/CheckTokenRequest")
     *       },
     *      )
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="OK",
     *      @OA\JsonContent(
     *       allOf={
     *          @OA\Schema(ref="#/components/schemas/User"),
     *       }
     *      )
     *    ),
     *    @OA\Response(response=403, description="Forbidden",
     *       @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *    )
     * )
     */
    public function check(Request $request)
    {
        $this->validate($request, \App\Requests\CheckTokenRequest::defaultValidatorRules());
        $jwt = $request->input("token", "");
        $app_id = $request->input("app_id", "");

        $request->headers->set('Authorization', 'Bearer ' . $jwt);
        $currentUser = Auth::user();
        if ($currentUser) {
            return response()->json($currentUser, 200);
        }
        return response()->json(null, 403);
    }

}
