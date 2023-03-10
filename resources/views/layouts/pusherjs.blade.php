<script>
    // Enable pusher logging - don't include this in production
    @if($user_data)
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{config('broadcasting.connections.pusher.key')}}', {
            cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}',
            encrypted: true,
        });

        var chanel = pusher.subscribe('{{ 'mail_compose_channel'.$user_data->id }}');
        chanel.bind('App\\Events\\Email\\EmailSentEvent', function(data) {
            Lobibox.notify('info', {
                delay: 10000,
                continueDelayOnInactiveTab: false,
                pauseDelayOnHover: true,
                rounded: true,
                icon: false,
                title: 'Email',
                msg: data.message,
            });
        });
    @endif
</script>
