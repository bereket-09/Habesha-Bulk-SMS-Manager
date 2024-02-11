<?php

namespace App\Http\Controllers\Customer;

use App\Http\Requests\Campaigns\CampaignBuilderRequest;
use App\Http\Requests\Campaigns\ImportRequest;
use App\Http\Requests\Campaigns\ImportVoiceRequest;
use App\Http\Requests\Campaigns\MMSCampaignBuilderRequest;
use App\Http\Requests\Campaigns\MMSImportRequest;
use App\Http\Requests\Campaigns\MMSQuickSendRequest;
use App\Http\Requests\Campaigns\OTPCampaignBuilderRequest;
use App\Http\Requests\Campaigns\OTPQuickSendRequest;
use App\Http\Requests\Campaigns\QuickSendRequest;
use App\Http\Requests\Campaigns\ViberCampaignBuilderRequest;
use App\Http\Requests\Campaigns\ViberQuickSendRequest;
use App\Http\Requests\Campaigns\VoiceCampaignBuilderRequest;
use App\Http\Requests\Campaigns\VoiceQuickSendRequest;
use App\Http\Requests\Campaigns\WhatsAppCampaignBuilderRequest;
use App\Http\Requests\Campaigns\WhatsAppQuickSendRequest;
use App\Library\Tool;
use App\Models\Campaigns;
use App\Models\ContactGroups;
use App\Models\Country;
use App\Models\CsvData;
use App\Models\CustomerBasedPricingPlan;
use App\Models\CustomerBasedSendingServer;
use App\Models\PhoneNumbers;
use App\Models\Plan;
use App\Models\PlansCoverageCountries;
use App\Models\Senderid;
use App\Models\Templates;
use App\Models\TemplateTags;
use App\Models\User;
use App\Repositories\Contracts\CampaignRepository;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;



class TriviaController extends CustomerBaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    
    /**
     * Viber quick send
     *
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function TriviaQuickSend(): View|Factory|RedirectResponse|Application
    {

        // dd('test');
        $this->authorize('viber_quick_send');

        $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.Viber')],
                ['name' => __('locale.menu.Quick Send')],
        ];

        $sender_ids = Auth::user()->customer->getOption('sender_id_verification') === 'yes'
                ? Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->get()
                : null;

        $phone_numbers = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->get();

        $activeSubscription = Auth::user()->customer->activeSubscription();
        if ( ! $activeSubscription) {
            return redirect()->route('customer.subscriptions.index')->with([
                    'status'  => 'error',
                    'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $plan_id = $activeSubscription->plan_id;

        $coverage = CustomerBasedPricingPlan::where('status', true)
                                            ->where('user_id', Auth::user()->id)
                                            ->get();

        if ($coverage->count() < 1) {
            $coverage = PlansCoverageCountries::where('plan_id', $plan_id)
                                              ->where('status', true)
                                              ->get();
        }

        $templates      = Templates::where('user_id', auth()->user()->id)->where('status', 1)->get();
        $sendingServers = CustomerBasedSendingServer::where('user_id', auth()->user()->id)->where('status', 1)->get();

        return view('customer.Campaigns.trivias', compact('breadcrumbs', 'sender_ids', 'phone_numbers', 'coverage', 'templates', 'sendingServers'));
    }
    /**
     * campaign builder
     *
     * @return Application|Factory|View|RedirectResponse
     * @throws AuthorizationException
     */
    public function TriviaCampaignBuilder(): View|Factory|RedirectResponse|Application
    {
        $this->authorize('sms_campaign_builder');

        $breadcrumbs = [
                ['link' => url('dashboard'), 'name' => __('locale.menu.Dashboard')],
                ['link' => url('dashboard'), 'name' => __('locale.menu.SMS')],
                ['name' => __('locale.menu.Trivia Builder')],
        ];

        $compactData                = $this->getCampaignBuilderData();
        $compactData['breadcrumbs'] = $breadcrumbs;


        return view('customer.Campaigns.triviaBuilder', $compactData);
    }


     /**
     * @return array|RedirectResponse
     */
    private function getCampaignBuilderData()
    {

        $customer = Auth::user()->customer;

        if ( ! $customer->activeSubscription()) {
            return redirect()->route('customer.subscriptions.index')->with([
                    'status'  => 'error',
                    'message' => __('locale.customer.no_active_subscription'),
            ]);
        }

        $sender_ids = $customer->getOption('sender_id_verification') === 'yes'
                ? Senderid::where('user_id', auth()->user()->id)->where('status', 'active')->get()
                : null;

        $phone_numbers  = PhoneNumbers::where('user_id', auth()->user()->id)->where('status', 'assigned')->get();
        $template_tags  = TemplateTags::get();
        $contact_groups = ContactGroups::where('status', 1)->where('customer_id', auth()->user()->id)->get();
        $templates      = Templates::where('user_id', auth()->user()->id)->where('status', 1)->get();
        $sendingServers = CustomerBasedSendingServer::where('user_id', auth()->user()->id)->where('status', 1)->get();


        $plan_id = $customer->activeSubscription()->plan_id;

        return [
                'sender_ids'     => $sender_ids,
                'phone_numbers'  => $phone_numbers,
                'template_tags'  => $template_tags,
                'contact_groups' => $contact_groups,
                'templates'      => $templates,
                'plan_id'        => $plan_id,
                'sendingServers' => $sendingServers,
        ];

    }
}
