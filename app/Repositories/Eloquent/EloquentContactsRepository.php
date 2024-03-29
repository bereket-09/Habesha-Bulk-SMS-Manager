<?php

namespace App\Repositories\Eloquent;

use App\Exceptions\GeneralException;
use App\Library\Tool;
use App\Models\Campaigns;
use App\Models\ContactGroups;
use App\Models\Contacts;
use App\Models\ContactsCustomField;
use App\Repositories\Contracts\ContactsRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Throwable;

class EloquentContactsRepository extends EloquentBaseRepository implements ContactsRepository
{
    /**
     * EloquentContactsRepository constructor.
     *
     * @param  ContactGroups  $contactGroups
     */
    public function __construct(ContactGroups $contactGroups)
    {
        parent::__construct($contactGroups);
    }

    /**
     * @param  array  $input
     *
     * @return ContactGroups
     *
     * @throws GeneralException
     */
    public function store(array $input): ContactGroups
    {
        /** @var ContactGroups $contactGroups */
        $contactGroups = $this->make(Arr::only($input, ['name']));

        if ( ! isset($input['send_welcome_sms'])) {
            $contactGroups->send_welcome_sms = false;
        }

        if ( ! isset($input['unsubscribe_notification'])) {
            $contactGroups->unsubscribe_notification = false;
        }

        if ( ! isset($input['send_keyword_message'])) {
            $contactGroups->send_keyword_message = false;

        }
        if ( ! isset($input['user_id'])) {
            $contactGroups->customer_id = auth()->user()->id;
        } else {
            $contactGroups->customer_id = $input['user_id'];
        }

        $contactGroups->status = true;

        if ( ! $this->save($contactGroups)) {
            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        }

        return $contactGroups;

    }

    /**
     * @param  ContactGroups  $contactGroups
     *
     * @return bool
     */
    private function save(ContactGroups $contactGroups): bool
    {
        if ( ! $contactGroups->save()) {
            return false;
        }

        return true;
    }

    /**
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return ContactGroups
     * @throws Exception|Throwable
     *
     * @throws Exception
     */
    public function update(ContactGroups $contactGroups, array $input): ContactGroups
    {
        if (isset($input['originator'])) {
            if ($input['originator'] == 'sender_id') {
                $sender_id = $input['sender_id'];
            } else {
                $sender_id = $input['phone_number'];
            }
            $input['sender_id'] = $sender_id;
        }

        if ( ! isset($input['send_welcome_sms'])) {
            $input['send_welcome_sms'] = false;
        }

        if ( ! isset($input['unsubscribe_notification'])) {
            $input['unsubscribe_notification'] = false;
        }

        if ( ! isset($input['send_keyword_message'])) {
            $input['send_keyword_message'] = false;
        }

        if ( ! $contactGroups->update($input)) {
            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        }

        return $contactGroups;
    }

    /**
     * @param  ContactGroups  $contactGroups
     *
     * @return bool|null
     * @throws Exception|Throwable
     *
     */
    public function destroy(ContactGroups $contactGroups)
    {
        if ( ! $contactGroups->delete()) {
            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        }

        Contacts::where('customer_id', Auth::user()->id)->where('group_id', $contactGroups->id)->delete();

        return true;

    }

    /**
     * @param  array  $ids
     *
     * @return mixed
     * @throws Exception|Throwable
     *
     */
    public function batchDestroy(array $ids): bool
    {
        DB::transaction(function () use ($ids) {
            // This won't call eloquent events, change to destroy if needed
            if ($this->query()->whereIn('uid', $ids)->delete()) {
                return true;
            }

            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        });

        return true;

    }

    /**
     * @param  array  $ids
     *
     * @return mixed
     * @throws Exception|Throwable
     *
     */
    public function batchActive(array $ids): bool
    {
        DB::transaction(function () use ($ids) {
            if ($this->query()->whereIn('uid', $ids)
                     ->update(['status' => true])
            ) {
                return true;
            }

            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        });

        return true;
    }

    /**
     * @param  array  $ids
     *
     * @return mixed
     * @throws Exception|Throwable
     *
     */
    public function batchDisable(array $ids): bool
    {
        DB::transaction(function () use ($ids) {
            if ($this->query()->whereIn('uid', $ids)
                     ->update(['status' => false])
            ) {
                return true;
            }

            throw new GeneralException(__('locale.exceptions.something_went_wrong'));
        });

        return true;
    }


    /**
     * store new contact
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function storeContact(ContactGroups $contactGroups, array $input): JsonResponse
    {

        $phone = str_replace(['+', '(', ')', '-', ' '], '', $input['phone']);
        try {
            $phoneUtil         = PhoneNumberUtil::getInstance();
            $phoneNumberObject = $phoneUtil->parse('+'.$phone);

            if ($phoneUtil->isPossibleNumber($phoneNumberObject)) {
                $contact = Contacts::create([
                        'customer_id' => $contactGroups->customer_id,
                        'group_id'    => $contactGroups->id,
                        'phone'       => $phone,
                        'status'      => 'subscribe',
                        'first_name'  => $input['first_name'],
                        'last_name'   => $input['last_name'],
                ]);

                if ($contact) {

                    $sendMessage = new EloquentCampaignRepository($campaign = new Campaigns());

                    if ($contactGroups->send_welcome_sms && $contactGroups->welcome_sms) {
                        $message = Tool::renderSMS($contactGroups->welcome_sms, [
                                'first_name' => $input['first_name'],
                                'last_name'  => $input['last_name'],
                        ]);

                        $sendMessage->quickSend($campaign, [
                                'sender_id'      => $contactGroups->sender_id,
                                'sms_type'       => 'plain',
                                'message'        => $message,
                                'recipient'      => $phoneNumberObject->getNationalNumber(),
                                'user_id'        => $contactGroups->customer_id,
                                'country_code'   => $phoneNumberObject->getCountryCode(),
                                'exist_c_code'   => 'yes',
                        ]);

                    }

                    if ($contactGroups->signup_sms) {

                        $message = Tool::renderSMS($contactGroups->signup_sms, [
                                'first_name' => $input['first_name'],
                                'last_name'  => $input['last_name'],
                        ]);

                        $sendMessage->quickSend($campaign, [
                                'sender_id'      => $contactGroups->sender_id,
                                'sms_type'       => 'plain',
                                'message'        => $message,
                                'recipient'      => $phoneNumberObject->getNationalNumber(),
                                'user_id'        => $contactGroups->customer_id,
                                'country_code'   => $phoneNumberObject->getCountryCode(),
                                'exist_c_code'   => 'yes',
                        ]);

                    }

                    $contactGroups->updateCache('SubscribersCount');

                    return response()->json([
                            'status'  => 'success',
                            'contact' => $contact,
                            'message' => __('locale.contacts.contact_successfully_added'),
                    ]);
                }

                return response()->json([
                        'status'  => 'error',
                        'message' => __('locale.exceptions.something_went_wrong'),
                ]);
            }

            return response()->json([
                    'status'  => 'error',
                    'message' => __('locale.customer.invalid_phone_number', ['phone' => $phone]),
            ]);
        } catch (NumberParseException $exception) {
            return response()->json([
                    'status'  => 'error',
                    'message' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * update contact status
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return bool
     */
    public function updateContactStatus(ContactGroups $contactGroups, array $input): bool
    {
        try {
            $contact = Contacts::where('group_id', $contactGroups->id)->where('uid', $input['id'])->first();

            if ($contact) {
                if ($contact->status == 'subscribe') {
                    $status = 'unsubscribe';
                } else {
                    $status = 'subscribe';
                }

                if ($contact->update(['status' => $status])) {
                    return true;
                }

                return false;
            }

            return false;

        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * update single contact information
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return bool
     */
    public function updateContact(ContactGroups $contactGroups, array $input): bool
    {

        $contact = Contacts::where('group_id', $contactGroups->id)->where('uid', $input['contact_id'])->first();

        if ($contact) {

            $phone = str_replace(['+', '(', ')', '-', ' '], '', $input['phone']);
            try {
                $phoneUtil         = PhoneNumberUtil::getInstance();
                $phoneNumberObject = $phoneUtil->parse('+'.$phone);

                if ($phoneUtil->isPossibleNumber($phoneNumberObject)) {
                    if (isset($input['custom']) && is_array($input['custom']) && count($input['custom']) > 0) {
                        ContactsCustomField::where('contact_id', $contact->id)->delete();
                        foreach ($input['custom'] as $value) {
                            $value['contact_id'] = $contact->id;
                            ContactsCustomField::create($value);
                        }
                    }
                    $data          = array_except($input, ['custom', 'contact_id']);
                    $data['phone'] = $phone;

                    if ($contact->update($data)) {
                        return true;
                    }
                }
            } catch (NumberParseException) {
                return false;
            }

            return false;
        }

        return false;

    }

    /**
     * delete single contact from group
     *
     * @param  ContactGroups  $contactGroups
     * @param  string  $id
     *
     * @return bool
     */
    public function contactDestroy(ContactGroups $contactGroups, string $id): bool
    {
        $contact = Contacts::where('group_id', $contactGroups->id)->where('uid', $id)->first();
        if ($contact) {

            $contact->delete();

            $contactGroups->updateCache('SubscribersCount');

            return true;
        }

        return false;
    }

    /**
     * bulk contacts subscribe
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $ids
     *
     * @return bool
     */
    public function batchContactSubscribe(ContactGroups $contactGroups, array $ids): bool
    {
        $status = Contacts::where('group_id', $contactGroups->id)->whereIn('uid', $ids)->update([
                'status' => 'subscribe',
        ]);

        if ($status) {
            return true;
        }

        return false;
    }

    /**
     * bulk contact unsubscribe
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $ids
     *
     * @return bool
     */
    public function batchContactUnsubscribe(ContactGroups $contactGroups, array $ids): bool
    {
        $status = Contacts::where('group_id', $contactGroups->id)->whereIn('uid', $ids)->update([
                'status' => 'unsubscribe',
        ]);

        if ($status) {
            return true;
        }

        return false;
    }

    /**
     * bulk copy from one group to another group
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return bool
     */
    public function batchContactCopy(ContactGroups $contactGroups, array $input): bool
    {
        $phone_numbers = Contacts::where('group_id', $input['target_group'])->pluck('phone')->toArray();
        $existing_list = Contacts::where('group_id', $contactGroups->id)->whereIn('uid', $input['ids'])->cursor();

        foreach ($existing_list as $list) {
            if ( ! in_array($list->phone, $phone_numbers)) {
                $new_list           = $list->replicate();
                $new_list->group_id = $input['target_group'];
                $new_list->save();
            }
        }

        $target_group = ContactGroups::find($input['target_group']);
        $target_group?->updateCache('SubscribersCount');

        return true;
    }

    /**
     * bulk move from one group to another group
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $input
     *
     * @return bool
     */
    public function batchContactMove(ContactGroups $contactGroups, array $input): bool
    {
        $existing_list = Contacts::where('group_id', $contactGroups->id)->whereIn('uid', $input['ids'])->update([
                'group_id' => $input['target_group'],
        ]);

        if ($existing_list) {
            $target_group = ContactGroups::find($input['target_group']);
            $target_group?->updateCache('SubscribersCount');
            $contactGroups->updateCache('SubscribersCount');

            return true;
        }

        return false;
    }

    /**
     * bulk contacts delete from group
     *
     * @param  ContactGroups  $contactGroups
     * @param  array  $ids
     *
     * @return bool
     */
    public function batchContactDestroy(ContactGroups $contactGroups, array $ids): bool
    {
        $status = Contacts::where('group_id', $contactGroups->id)->whereIn('uid', $ids)->delete();
        if ($status) {
            $contactGroups->updateCache('SubscribersCount');

            return true;
        }

        return false;
    }

}
