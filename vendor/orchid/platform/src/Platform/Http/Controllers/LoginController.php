<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use App\Models\User;
use App\Notifications\NewsForAdmin;
use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Orchid\Access\Impersonation;
use App\Providers\RouteServiceProvider;
use Orchid\Platform\Models\Role;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * @var Guard|\Illuminate\Auth\SessionGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     */
    public function __construct(Auth $auth)
    {
        $this->guard = $auth->guard(config('platform.guard'));

        /**
         * @deprecated logic for older Laravel versions
         */
        $middleware = 'guest';

        if (InstalledVersions::satisfies(new VersionParser, 'laravel/framework', '>11.17.0')) {
            $middleware = RedirectIfAuthenticated::class;
            RedirectIfAuthenticated::redirectUsing(static fn () => route(config('platform.index')));
        }

        $this->middleware($middleware, [
            'except' => [
                'logout',
                'switchLogout',
            ],
        ]);
    }

    /**
     * Handle a login request to the application.
     *
     *
     * @throws ValidationException
     *
     * @return JsonResponse|RedirectResponse
     */
    public function login(Request $request, CookieJar $cookieJar)
    {
        $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $auth = $this->guard->attempt(
            $request->only(['email', 'password']),
            $request->boolean('remember')
        );

        if (! $auth) {
            throw ValidationException::withMessages([
                'email' => __('The details you entered did not match our records. Please double-check and try again.'),
            ]);
        }

        if ($request->boolean('remember')) {
            $user = $cookieJar->forever($this->nameForLock(), $this->guard->id());
            $cookieJar->queue($user);
        }



        return $this->sendLoginResponse($request);
    }

    /**
     * Send the response after the user was authenticated.
     *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->route('platform.main');
    }

    /**
     * @param Guard $guard
     *
     * @return Factory|View
     */
    public function showLoginForm(Request $request)
    {
        $user = $request->cookie($this->nameForLock());

        /** @var EloquentUserProvider $provider */
        $provider = $this->guard->getProvider();

        $model = $provider->createModel()->find($user);

        return view('platform::auth.login', [
            'isLockUser' => optional($model)->exists ?? false,
            'lockUser'   => $model,
        ]);
    }

    /**
     * @return RedirectResponse
     */
    public function resetCookieLockMe(CookieJar $cookieJar)
    {
        $lockUser = $cookieJar->forget($this->nameForLock());

        return redirect()->route('platform.login')->withCookie($lockUser);
    }

    /**
     * @return RedirectResponse
     */
    public function switchLogout()
    {
        Impersonation::logout();

        return redirect()->route(config('platform.index'));
    }

    /**
     * Log the user out of the application.
     *
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    private function nameForLock(): string
    {
        return sprintf('%s_%s', $this->guard->getName(), '_orchid_lock');
    }

    public function showRegisterForm()
    {
        return view('platform::auth.registration');

    }

    public function register(Request $request)
    {
        $admin = User::find(1);

        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $admin->notify(new NewsForAdmin('Новый пользователь', "Подтвердите регистрацию пользователя <a href='/users/$user->id/edit'> $user->name </a> и укажите его роль!"));


        \Illuminate\Support\Facades\Auth::login($user, false);


        return redirect(RouteServiceProvider::HOME);
    }
}
