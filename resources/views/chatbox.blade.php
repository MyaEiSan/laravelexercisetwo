<!DOCTYPE html>
<html>
    <head>
        <title>Chat Test</title>
        <meta name="csrf-token" content="{{csrf_token() }}"/>
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    
    </head>
    <body>
        <h1>Chat Test</h1>
        <p>
            Try publishing an event to channel <code>my-channel</code>
            with event name <code>my-event</code>.
        <div>
            <div id="display">
                {{-- message will be shown in here  --}}
            </div>
        
            <input type="text" id="message" placeholder="Write Something..." />
            <button type="button" id="send">Send</button>
        
        </div>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script>
        
            $(document).ready(function(){
                // Enable pusher logging - don't include this in production
                Pusher.logToConsole = true;
        
                var pusher = new Pusher('1a4a951918c078cb4994', {
                cluster: 'ap1'
                });
        
                var channel = pusher.subscribe('chat-channel');
        
                channel.bind('message-event', function(data) {
                    console.log(data);
                });
        
                $("#send").click(function(){
                    const message = $("#message").val();
                    
                    $.ajax({
                        url: '/chatmessages', 
                        type: 'POST', 
                        data:{
                            sms:message
                        }, 
                        headers:{
                            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                        }, 
                        success: function(response){
                            console.log(response);
                        }
                    })
                });
        
            });
        
            
        </script>
    
    </body>
</html>