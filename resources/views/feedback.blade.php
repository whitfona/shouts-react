@component('mail::message')
    # Hello,

    Shouts received the following feedback:

    {{$data['message']}}

@endcomponent
