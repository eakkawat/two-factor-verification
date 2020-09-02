@component('mail::message')
# Introduction

Your otp is {{$otp}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
