<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Library\Tool;
use App\Models\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class APIController extends Controller
{
    use ApiResponser;

    /**
     * get profile
     *
     * @return JsonResponse
     */

    public function me(): JsonResponse
    {

        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $user = auth()->user();

        $data = [
                'uid'            => $user->uid,
                'api_token'      => $user->api_token,
                'first_name'     => $user->first_name,
                'last_name'      => $user->last_name,
                'email'          => $user->email,
                "locale"         => $user->locale,
                "timezone"       => $user->timezone,
                "last_access_at" => Tool::customerDateTime($user->last_access_at),
        ];

        return $this->success($data);
    }

    /**
     * get balance information
     *
     * @return JsonResponse
     */
    public function balance(): JsonResponse
    {

        if (config('app.stage') == 'demo') {
            return response()->json([
                    'status'  => 'error',
                    'message' => 'Sorry! This option is not available in demo mode',
            ]);
        }

        $user = Auth::user();

        $data = [
                'remaining_balance' => $user->sms_unit == '-1' ? __('locale.labels.unlimited') : Tool::format_price($user->sms_unit, $user->customer->subscription->plan->currency->format),
                'expired_on'        => Tool::customerDateTime($user->customer->subscription->current_period_ends_at),
        ];

        return $this->success($data);

    }

}
