<x-mail::message>
# Olá {{ $clientName }},
<br>

<p>Sua senha foi alterada e os dados de acesso estão logo abaixo.</p>
<br>

<p>
<b>Painel:</b> <a href="{{ config('app.url')}}/casal/login" target="_blank">{{ config('app.url')}}/casal/login</a><br>
<b>E-Mail:</b> {{ $email }}<br>
<b>Senha:</b> {{ $pass }}
</p>
<br>

Saudações,<br>
{{ config('app.name') }}
</x-mail::message>
