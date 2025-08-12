<!DOCTYPE html>
<html class="no-js" lang="{{ locale() }}">
@include('client.layout.partial._head')


<body>

@yield('content')

{{--    <script src="https://www.google.com/recaptcha/api.js" async defer></script>--}}

{{--    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITEKEY') }}"></script>--}}
{{--    <script>--}}
{{--        grecaptcha.ready(function() {--}}
{{--            grecaptcha.execute('{{ env('RECAPTCHA_SITEKEY') }}', {action: 'submit'}).then(function(token) {--}}
{{--                document.getElementById('recaptcha_token').value = token;--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

    <script src="/client/js/design.js?v={{ time() }}"></script>
    @stack('js')
</body>

</html>
