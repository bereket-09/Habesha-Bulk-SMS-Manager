@php use App\Helpers\Helper;use App\Library\Tool;use App\Models\Automation; @endphp
@extends('layouts/contentLayoutMaster')

@section('title', __('locale.automations.say_happy_birthday'))

@section('vendor-style')
    <!-- vendor css files -->
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection

@section('page-style')

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/pickers/form-flat-pickr.css')) }}">

    <style>
        .customized_select2 .select2-selection--multiple {
            border-left: 0;
            border-radius: 0 4px 4px 0;
            min-height: 2.75rem !important;
        }

        .customized_select2 .select2-selection--single, .input_sender_id {
            border-left: 0;
            border-radius: 0 4px 4px 0;
            min-height: 2.75rem !important;
        }
    </style>

    
<style>
        .select2-container--default .select2-selection--single {
            min-height: 38px;
            border-radius: 4px 0 0 4px;
        }

        .active {
            margin: 0 auto;
            background: #7181844d;
            color: #121213;
            border-radius: 5px;
        }

        .campaign_side_bar {
            padding: 10px 20px;
        }

        .js-irs-2 {
            display: none !important;
        }

        #range_5 {
            display: none !important;
        }

        .irs-handle .single {
            cursor: pointer !important;
        }

        .active_btn {
            background: #ec0b0b !important;
            border-color: inherit !important;
        }

        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            background-color: #d4d9da !important;
        }

        #custom_tabs_one_tabContent .tab-pane {
            padding: 0px !important;
        }

        .campaign_side_bar {
            cursor: not-allowed !important;
        }
        .response_value{
            padding: 10px 0px 10px 20px;
            cursor: pointer;
            color: black !important;
            border-bottom: 0.5px solid #e0e2e6;
        }
        #showResponse{
            z-index: 99;
            color: black;
            overflow-y: auto;
            border-radius: 5px;
            position: absolute;
            background: #f2efef;
            top: 87%;
            width: 95%;
            left: 20px;
        }
        .from_type_btn.active{
            background-color: rgb(5 187 201) !important;
            border-color: rgb(5 187 201) !important;
            color: white;
        }
        .daterangepicker.show-calendar{
            top: 712px !important;
        }
        #mobileVersion{
    display: block;

}

.chat *{
    transition:all .5s;
    box-sizing:border-box;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
}

.chat {
    margin:0;
    cursor:default;
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    top:0;
    -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none;   /* Chrome/Safari/Opera */
    -khtml-user-select: none;    /* Konqueror */
    -moz-user-select: none;      /* Firefox */
    -ms-user-select: none;       /* IE/Edge */
    user-select: none;
}

.chat span.spinner{
    -moz-animation: loading-bar 1s 1;
    -webkit-animation: loading-bar 1s 1;
    animation: loading-bar 1s 1;
    display: block;
    height: 2px;
    background-color: #00e34d;
    transition: width 0.2s;
    position:absolute;
    top:0; left:0; right:0;
    z-index:4
}

.chat .messages{
    display:block;
    overflow-x: hidden;
    overflow-y: scroll;
    position:relative;
    height:90%;
    width:100%;
    padding:2% 3%;
    border-bottom:1px solid #ecf0f1;
}

.chat ::-webkit-scrollbar {width: 3px; height:1px;transition:all .5s;z-index:10;}
.chat ::-webkit-scrollbar-track {background-color: white;}
.chat ::-webkit-scrollbar-thumb {
    background-color: #bec4c8;
    border-radius:3px;
}

.chat .message{
    display:block;
    width:98%;
    padding:0.5%;
}

.chat .message p{
    margin:0;
}

.chat .myMessage,
.chat .fromThem {
    max-width: 50%;
    word-wrap: break-word;
    margin-bottom: 20px;
}

form.chat .message:hover .myMessage{
    -webkit-transform: translateX(-10px);
    transform: translateX(-10px);
}

.chat .message:hover .fromThem{
    -webkit-transform: translateX(130px);
    transform: translateX(130px);
}

.chat .message:hover date {
    opacity: 1;
}

.chat .myMessage,.fromThem{
    position: relative;
    padding: 10px 20px;
    color: white;
    border-radius: 25px;
    clear: both;
    font: 400 15px 'Open Sans', sans-serif;
}

.chat .myMessage {
    background: #dee2e6;
    color:#000b16;
    float:right;
    clear:both;
    border-bottom-right-radius: 20px 0px\9;
}

.chat .myMessage:before {
    content: "";
    position: absolute;
    z-index: 1;
    bottom: -2px;
    right: -8px;
    height: 19px;
    border-right: 20px solid #dee2e6;
    border-bottom-left-radius: 16px 14px;
    -webkit-transform: translate(0, -2px);
    transform: translate(0, -2px);
    border-bottom-left-radius: 15px 0px\9;
    transform: translate(-1px, -2px)\9;
}

.chat .myMessage:after {
    content: "";
    position: absolute;
    z-index: 1;
    bottom: -2px;
    right: -42px;
    width: 12px;
    height: 20px;
    background: white;
    border-bottom-left-radius: 10px;
    -webkit-transform: translate(-30px, -2px);
    transform: translate(-30px, -2px);
}

.chat .fromThem {
    background: #E5E5EA;
    color: black;
    float: left;
    clear:both;
    border-bottom-left-radius: 30px 0px\9;
}
.chat .fromThem:before {
    content: "";
    position: absolute;
    z-index: 2;
    bottom: -2px;
    left: -7px;
    height: 19px;
    border-left: 20px solid #E5E5EA;
    border-bottom-right-radius: 16px 14px;
    -webkit-transform: translate(0, -2px);
    transform: translate(0, -2px);
    border-bottom-right-radius: 15px 0px\9;
    transform: translate(-1px, -2px)\9;
}

.chat .fromThem:after {
    content: "";
    position: absolute;
    z-index: 3;
    bottom: -2px;
    left: 4px;
    width: 26px;
    height: 20px;
    background: white;
    border-bottom-right-radius: 10px;
    -webkit-transform: translate(-30px, -2px);
    transform: translate(-30px, -2px);
}

.chat date {
    position:absolute;
    top: 10px;
    font-size:14px;
    white-space:nowrap;
    vertical-align:middle;
    color: #8b8b90;
    opacity: 0;
    z-index:4;
}

.chat .myMessage date {
    left: 105%;
}

.chat .fromThem date {
    right: 105%;
}

.chat input{
    font: 400 13px 'Open Sans', sans-serif;
    border:0;
    padding:0 15px;
    height:10%;
    outline:0;
}

.chat input[type='text']{
    width:73%;
    float:left;
}

.chat input[type='submit']{
    width:23%;
    background:transparent;
    color:#000b16;
    font-weight:700;
    text-align:right;
    float:right;
}

.chat .myMessage,form.chat .fromThem{
    font-size:12px;
}

.chat .message:hover .myMessage{
    transform: translateY(18px);
    -webkit-transform: translateY(18px);
}

.chat .message:hover .fromThem{
    transform: translateY(18px);
    -webkit-transform: translateY(18px);
}

.chat .myMessage date,.chat .fromThem date {
    top: -20px;
    left:auto;
    right:0;
    font-size:12px;
}

.chat .myMessage,
.chat .fromThem {
    max-width: 90%;
}

@-moz-keyframes loading-bar {
    0% {
        width: 0%;
    }
    90% {
        width: 90%;
    }
    100% {
        width: 100%;
    }
}

@-webkit-keyframes loading-bar {
    0% {
        width: 0%;
    }
    90% {
        width: 90%;
    }
    100% {
        width: 100%;
    }
}

@keyframes loading-bar {
    0% {
        width: 0%;
    }
    90% {
        width: 90%;
    }
    100% {
        width: 100%;
    }
}

/* DEMO */
.iphone {
    width: 300px;
    height: 609px;
    background-size: 100% 100%;
    margin: 0 auto;
    position: relative;
}

.border{
    position:absolute;
    top:12.3%;right:7%;left:7%;bottom:12%;
    overflow:hidden;
}

a.article{
    position:fixed;
    bottom:15px;left:15px;
    display:table;
    text-decoration:none;
    color:white;
    background-color:#00e34d;
    padding: 10px 20px;
    border-radius: 25px;
    font: 400 15px 'Open Sans', sans-serif;
}
.schedule_date{
    border-radius: 50px !important;
}
.c-card{
    background-color: #f2f2f2;
}
#mobileVersion{
    display: block;
}
@media (max-width:700px) {
    #mobileVersion{
        display: none;
    }
}
    </style>



@endsection

@section('content')

    <!-- Basic Vertical form layout section start -->
    <section id="basic-vertical-layouts campaign_builder">
        <div class="row match-height">
            <div class="col-md-8 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">

                            <form class="form form-vertical" action="{{ route('customer.automations.say.happy.birthday') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="name" class="required form-label">{{ __('locale.labels.name') }}</label>
                                            <input type="text"
                                                   id="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
                                                   name="name" required
                                                   placeholder="{{__('locale.labels.required')}}" autofocus>
                                            @error('name')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    @if($sendingServers->count() > 0)
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="sending_server" class="form-label required">{{ __('locale.labels.sending_server') }}</label>
                                                <select class="select2 form-select" name="sending_server">
                                                    @foreach($sendingServers as $server)
                                                        <option value="{{$server->sendingServer->id}}"> {{ $server->sendingServer->name }}</option>
                                                    @endforeach
                                                </select>

                                                @error('sending_server')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>

                                    @endif

                                    @can('view_sender_id')
                                        @if(auth()->user()->customer->getOption('sender_id_verification') == 'yes')
                                            <div class="col-12">
                                                <p class="text-uppercase">{{ __('locale.labels.originator') }}</p>
                                            </div>

                                            <div class="col-md-6 col-12 customized_select2">
                                                <div class="mb-1">
                                                    <label for="sender_id" class="form-label">{{ __('locale.labels.sender_id') }}</label>
                                                    <div class="input-group">
                                                        <div class="input-group-text">
                                                            <div class="form-check">
                                                                <input type="radio" class="form-check-input sender_id" name="originator" checked value="sender_id" id="sender_id_check"/>
                                                                <label class="form-check-label" for="sender_id_check"></label>
                                                            </div>
                                                        </div>

                                                        <div style="width: 17rem">
                                                            <select class="form-select select2" id="sender_id" name="sender_id[]">
                                                                @foreach($sender_ids as $sender_id)
                                                                    <option value="{{$sender_id->sender_id}}"> {{ $sender_id->sender_id }} </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            @can('view_numbers')
                                                <div class="col-md-6 col-12 customized_select2">

                                                    <div class="mb-1">
                                                        <label for="sender_id" class="form-label">{{ __('locale.labels.sender_id') }}</label>
                                                        <div class="input-group">
                                                            <div class="input-group-text">
                                                                <div class="form-check">
                                                                    <input type="radio" class="form-check-input sender_id" name="originator" checked value="sender_id" id="sender_id_check"/>
                                                                    <label class="form-check-label" for="sender_id_check"></label>
                                                                </div>
                                                            </div>

                                                            <div style="width: 17rem">
                                                                <input type="text" id="sender_id"
                                                                       class="form-control input_sender_id @error('sender_id') is-invalid @enderror"
                                                                       name="sender_id[]">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            @else
                                                <div class="col-12">
                                                    <div class="mb-1">
                                                        <label for="sender_id" class="form-label">{{__('locale.labels.sender_id')}}</label>
                                                        <input type="text" id="sender_id"
                                                               class="form-control @error('sender_id') is-invalid @enderror"
                                                               name="sender_id[]">
                                                        @error('sender_id')
                                                        <p><small class="text-danger">{{ $message }}</small></p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endcan
                                        @endif
                                    @endcan

                                    @can('view_numbers')
                                        <div class="col-md-6 col-12 customized_select2">
                                            <div class="mb-1">
                                                <label for="phone_number" class="form-label">{{ __('locale.menu.Phone Numbers') }}</label>
                                                <div class="input-group">
                                                    <div class="input-group-text">
                                                        <div class="form-check">
                                                            <input type="radio" class="form-check-input phone_number" value="phone_number" name="originator" id="phone_number_check"/>
                                                            <label class="form-check-label" for="phone_number_check"></label>
                                                        </div>
                                                    </div>

                                                    <div style="width: 17rem">
                                                        <select class="form-select select2" disabled id="phone_number" name="phone_number[]" multiple>
                                                            @foreach($phone_numbers as $number)
                                                                <option value="{{ $number->number }}"> {{ $number->number }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endcan

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="contact_groups" class="form-label">{{ __('locale.contacts.contact_groups') }}</label>
                                            <select class="select2 form-select" name="contact_groups" id="contact_groups">
                                                @foreach($contact_groups as $group)
                                                    <option value="{{$group->id}}"> {{ $group->name }}
                                                        ({{Tool::number_with_delimiter($group->subscribersCount($group->cache))}} {{__('locale.menu.Contacts')}})
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('contact_groups')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="sms_template form-label" for="sms_template">{{__('locale.permission.sms_template')}}</label>
                                            <select class="form-select select2" id="sms_template">
                                                <option>{{ __('locale.labels.select_one') }}</option>
                                                @foreach($templates as $template)
                                                    <option value="{{$template->id}}">{{ $template->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="available_tag">{{__('locale.labels.available_tag')}}</label>
                                            <select class="form-select select2" id="available_tag">
                                                <option value="phone">{{ __('locale.labels.phone') }}</option>
                                                <option value="first_name">{{ __('locale.labels.first_name') }}</option>
                                                <option value="last_name">{{ __('locale.labels.last_name') }}</option>
                                                <option value="email">{{ __('locale.labels.email') }}</option>
                                                <option value="username">{{ __('locale.labels.username') }}</option>
                                                <option value="company">{{ __('locale.labels.company') }}</option>
                                                <option value="address">{{ __('locale.labels.address') }}</option>
                                                <option value="birth_date">{{ __('locale.labels.birth_date') }}</option>
                                                <option value="anniversary_date">{{ __('locale.labels.anniversary_date') }}</option>

                                                @if($template_tags)
                                                    @foreach($template_tags as $field)
                                                        <option value="{{$field->tag}}">{{ $field->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    @if(config('app.trai_dlt'))
                                        <div class="col-12">
                                            <div class="mb-1">
                                                <label for="dlt_template_id" class="form-label required">{{ __('locale.templates.dlt_template_id') }}</label>
                                                <input type="text"
                                                       id="dlt_template_id"
                                                       class="form-control @error('dlt_template_id') is-invalid @enderror"
                                                       name="dlt_template_id"
                                                       required>
                                                @error('dlt_template_id')
                                                <p><small class="text-danger">{{ $message }}</small></p>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="sms_type" class="form-label required">{{__('locale.labels.sms_type')}}</label>
                                            <select class="form-select" id="sms_type" name="sms_type">
                                                @can('sms_campaign_builder')
                                                    <option value="plain" @if(old('sms_type') == 'plain') selected @endif> {{ __('locale.labels.plain') }}</option>
                                                @endcan

                                                @can('voice_campaign_builder')
                                                    <option value="voice" @if(old('sms_type') == 'voice') selected @endif> {{ __('locale.labels.voice') }}</option>
                                                @endcan

                                                @can('mms_campaign_builder')
                                                    <option value="mms" @if(old('sms_type') == 'mms') selected @endif> {{ __('locale.labels.mms') }}</option>\
                                                @endcan

                                                @can('whatsapp_campaign_builder')
                                                    <option value="whatsapp" @if(old('sms_type') == 'whatsapp') selected @endif> {{ __('locale.labels.whatsapp') }}</option>
                                                @endcan

                                                @can('viber_campaign_builder')
                                                    <option value="viber" @if(old('sms_type') == 'viber') selected @endif> {{ __('locale.menu.Viber') }}</option>
                                                @endcan
                                            </select>
                                        </div>
                                        @error('sms_type')
                                        <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>


                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="message" class="required form-label">{{__('locale.labels.message')}}</label>
                                            <textarea class="form-control" name="message" rows="5" id="message"></textarea>
                                            <div class="d-flex justify-content-between">
                                                <small class="text-primary text-uppercase text-start" id="remaining">160 {{ __('locale.labels.characters_remaining') }}</small>
                                                <small class="text-primary text-uppercase text-end" id="messages">1 {{ __('locale.labels.message') }} (s)</small>
                                            </div>
                                            @error('message')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12 show-voice">
                                        <div class="mb-1">
                                            <label class="required form-label" for="voice_language">{{ __('locale.labels.language') }}</label>
                                            <select class="form-select select2" id="voice_language" name="language" required>
                                                @foreach(Helper::voice_regions() as $key => $value)
                                                    <option value="{{$key}}" {{ $key == 'en-GB' ? 'selected': null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12 show-voice">
                                        <div class="mb-1">
                                            <label class="required form-label" for="gender">{{ __('locale.labels.gender') }}</label>
                                            <select class="form-select" id="gender" name="gender">
                                                <option value="male"> {{ __('locale.labels.male') }}</option>
                                                <option value="female"> {{ __('locale.labels.female') }}</option>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-12 show-mms">
                                        <div class="mb-1">
                                            <label for="mms_file" class="form-label required">{{__('locale.labels.mms_file')}}</label>
                                            <input type="file" name="mms_file" class="form-control" id="mms_file" accept="image/*,video/*"/>
                                            @error('mms_file')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 show-language">
                                        <div class="mb-1">
                                            <label class="required form-label" for="language">{{ __('locale.labels.language') }}</label>
                                            <select class="form-select" id="language" name="whatsapp_language" required>
                                                @foreach(Helper::whatsapp_languages() as $key => $value)
                                                    <option value="{{$key}}" {{ $key == 'en-GB' ? 'selected': null }}> {{ $value }} </option>
                                                @endforeach
                                            </select>

                                            @error('language')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 show-whatsapp">
                                        <div class="mb-1">
                                            <label for="whatsapp_mms_file" class="form-label">{{__('locale.labels.mms_file')}}</label>
                                            <input type="file" name="whatsapp_mms_file" class="form-control" id="whatsapp_mms_file" accept="image/*,video/*"/>
                                            @error('whatsapp_mms_file')
                                            <div class="text-danger">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="before" class="form-label required">{{__('locale.automations.before')}}</label>
                                            <select class="form-select" id="before" name="before">
                                                @foreach(Automation::getDelayBeforeOptions() as $limits)
                                                    <option value="{{$limits['value']}}"> {{ $limits['text'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('before')
                                        <p><small class="text-danger">{{ $message }}</small></p>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="at" class="form-label required">{{ __('locale.labels.at') }}</label>
                                            <input type="text" id="at" class="form-control flatpickr-time text-start" required name="at" placeholder="HH:MM"/>
                                            @error('at')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label for="timezone" class="form-label">{{__('locale.labels.timezone')}}</label>
                                            <select class="form-select select2" id="timezone" name="timezone">
                                                @foreach(Tool::allTimeZones() as $timezone)
                                                    <option value="{{$timezone['zone']}}" {{ Auth::user()->timezone == $timezone['zone'] ? 'selected': null }}> {{ $timezone['text'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('timezone')
                                            <p><small class="text-danger">{{ $message }}</small></p>
                                            @enderror
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <input type="hidden" value="{{$plan_id}}" name="plan_id">
                                        <button type="submit" class="btn btn-primary mt-1 mb-1"><i data-feather="send"></i> {{ __('locale.buttons.send') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-4" id="mobileVersion">
                                    <div class="iphone"
                                         style="background-image: url('{{asset('images/iphone6.png')}}')">
                                        <div class="border">
                                            <div class="responsive-html5-chat">
                                                <form class="chat -full">
                                                    <span></span>
                                                    <div class="messages">
                                                        <div class="message">
                                                            <div class="myMessage">   <p id="messageContent"></p>
                                                                <date><b></b> 23.06.2023 14:30:7</date>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="text" placeholder="Your message" disabled="">
                                                    <input type="submit" value="Send" disabled="">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
        </div>
        </div>
    </section>
    <!-- // Basic Vertical form layout section end -->

@endsection

@section('vendor-script')
    <!-- vendor files -->
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/dom-rules.js')) }}"></script>
@endsection

@section('page-script')

    <script src="{{ asset(mix('js/scripts/sms-counter.js')) }}"></script>

    <script>
        $(document).ready(function () {

            $('.schedule_date').flatpickr({
                minDate: "today",
                dateFormat: "Y-m-d",
                defaultDate: "{{ date('Y-m-d') }}",
            });

            $('.flatpickr-time').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                defaultDate: "{{ \Carbon\Carbon::now()->setTimezone(config('app.timezone'))->format('H:i') }}",
            });

            $(".sender_id").on("click", function () {
                $("#sender_id").prop("disabled", !this.checked);
                $("#phone_number").prop("disabled", this.checked);
            });

            $(".phone_number").on("click", function () {
                $("#phone_number").prop("disabled", !this.checked);
                $("#sender_id").prop("disabled", this.checked);
            });

            $(".select2").each(function () {
                let $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent()
                });
            });

            let $remaining = $('#remaining'),
                // $get_recipients = $('#recipients'),
                // number_of_recipients_ajax = 0,
                // number_of_recipients_manual = 0,
                $messages = $remaining.next(),
                $get_msg = $("#message"),
                merge_state = $('#available_tag'),
                sendingServer = $("#sending_server"),
                showLanguage = $(".show-language"),
                firstInvalid = $('form').find('.is-invalid').eq(0);

            if (firstInvalid.length) {
                $('body, html').stop(true, true).animate({
                    'scrollTop': firstInvalid.offset().top - 200 + 'px'
                }, 200);
            }


            showLanguage.hide();

            sendingServer.on('change', function (e) {
                e.preventDefault();
                let name = $(this).find(':selected').data('id')
                if (name === 'FBWhatsAppByTemplate') {
                    showLanguage.show();
                } else {
                    showLanguage.hide();
                }
            });

            $("#language").each(function () {
                let $this = $(this);
                $this.wrap('<div class="position-relative"></div>');
                $this.select2({
                    // the following code is used to disable x-scrollbar when click in select input and
                    // take 100% width in responsive also
                    dropdownAutoWidth: true,
                    width: '100%',
                    dropdownParent: $this.parent(),
                });
            });


            $.createDomRules({

                parentSelector: 'body',
                scopeSelector: 'form',
                showTargets: function (rule, $controller, condition, $targets, $scope) {
                    $targets.fadeIn();
                },
                hideTargets: function (rule, $controller, condition, $targets, $scope) {
                    $targets.fadeOut();
                },

                rules: [
                    {
                        controller: '#sms_type',
                        value: 'voice',
                        condition: '==',
                        targets: '.show-voice',
                    },
                    {
                        controller: '#sms_type',
                        value: 'mms',
                        condition: '==',
                        targets: '.show-mms',
                    },
                    {
                        controller: '#sms_type',
                        value: 'whatsapp',
                        condition: '==',
                        targets: '.show-whatsapp',
                    }
                ]
            });


            function isArabic(text) {
                let pattern = /[\u0600-\u06FF\u0750-\u077F]/;
                return pattern.test(text);
            }

            function get_character() {
                if ($get_msg[0].value !== null) {

                    let data = SmsCounter.count($get_msg[0].value, true);

                    if (data.encoding === 'UTF16') {
                        $('#sms_type').val('unicode').trigger('change');
                        if (isArabic($(this).val())) {
                            $get_msg.css('direction', 'rtl');
                        }
                    } else {
                        $('#sms_type').val('plain').trigger('change');
                        $get_msg.css('direction', 'ltr');
                    }

                    $remaining.text(data.remaining + " {!! __('locale.labels.characters_remaining') !!}");
                    $messages.text(data.messages + " {!! __('locale.labels.message') !!}" + '(s)');

                }

            }


            merge_state.on('change', function () {
                const caretPos = $get_msg[0].selectionStart;
                const textAreaTxt = $get_msg.val();
                let txtToAdd = this.value;
                if (txtToAdd) {
                    txtToAdd = '{' + txtToAdd + '}';
                }

                $get_msg.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos));
            });


            $("#sms_template").on('change', function () {

                let template_id = $(this).val();

                $.ajax({
                    url: "{{ url('templates/show-data')}}" + '/' + template_id,
                    type: "POST",
                    data: {
                        _token: "{{csrf_token()}}"
                    },
                    cache: false,
                    success: function (data) {
                        if (data.status === 'success') {
                            const caretPos = $get_msg[0].selectionStart;
                            const textAreaTxt = $get_msg.val();
                            let txtToAdd = data.message;

                            $('#dlt_template_id').val(data.dlt_template_id);

                            $get_msg.val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos)).val().length;

                            get_character();

                        } else {
                            toastr['warning'](data.message, "{{ __('locale.labels.attention') }}", {
                                closeButton: true,
                                positionClass: 'toast-top-right',
                                progressBar: true,
                                newestOnTop: true,
                                rtl: isRtl
                            });
                        }
                    },
                    error: function (reject) {
                        if (reject.status === 422) {
                            let errors = reject.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                toastr['warning'](value[0], "{{__('locale.labels.attention')}}", {
                                    closeButton: true,
                                    positionClass: 'toast-top-right',
                                    progressBar: true,
                                    newestOnTop: true,
                                    rtl: isRtl
                                });
                            });
                        } else {
                            toastr['warning'](reject.responseJSON.message, "{{__('locale.labels.attention')}}", {
                                closeButton: true,
                                positionClass: 'toast-top-right',
                                progressBar: true,
                                newestOnTop: true,
                                rtl: isRtl
                            });
                        }
                    }
                });
            });

            $get_msg.keyup(get_character);

        });
    </script>

    
<script>
    // Wait for the DOM to be ready
    document.addEventListener("DOMContentLoaded", function() {
        // Hide the myMessage div initially
        var myMessageDiv = document.querySelector('.myMessage');
        myMessageDiv.style.display = 'none';

        // Add event listener to the textarea
        document.getElementById('message').addEventListener('input', function() {
            // Update the content of the p tag inside myMessage
            var messageContent = document.getElementById('messageContent');
            
            messageContent.innerText = this.value;

            // Check the length of the message
            if (this.value.length > 0) {
                // If the message has content, show the myMessage div
                myMessageDiv.style.display = 'block';
            } else {
                // If the message is empty, hide the myMessage div
                myMessageDiv.style.display = 'none';
            }
        });
    });
</script>
@endsection
