<?php

/*
 * This file is part of Laravel Middlewares.
 *
 * (c) Brian Faust <hello@brianfaust.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BrianFaust\Middlewares;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Vinkla\Recaptcha\Recaptcha;
use Vinkla\Recaptcha\RecaptchaException;

class VerifyRecaptcha
{
    private $config;

    /**
     * The middleware constructor.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $recaptcha = new Recaptcha($this->config->get('recaptcha.secret'));

        try {
            $recaptcha->verify($request->get('g-recaptcha-response') ?? 'invalid_captcha');
        } catch (RecaptchaException $e) {
            alert()->error(__('invalid_captcha'));

            return back()->withInput();
        }

        return $next($request);
    }
}
