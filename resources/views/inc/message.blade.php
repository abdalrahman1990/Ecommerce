@if(Session::has('status'))
    <!-- This will make a Toast for Message whenever we have status (it's just a word) in our Session -->
    <script>
        M.toast({
            html: "<span>{{Session::get('status')}}</span><button class='btn-flat toast-action' onclick='toastInstance.dismiss()'><i class='material-icons yellow-text'>close</i></button>",
            inDuration:1000,
            outDuration:1000
        });
        var toastElement = document.querySelector('.toast');
        var toastInstance = M.Toast.getInstance(toastElement);
    </script>
@endif