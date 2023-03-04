@component('mail::message')
    # Hello,

    An inappropriate beer or comment has been submitted regarding:

    <strong>Beer Name:</strong> {{$data['beer_name']}}

    <strong>Beer ID:</strong> {{$data['beer_id']}}

    <strong>User report:</strong> {{$data['report']}}


@endcomponent
