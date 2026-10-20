@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Flux.toast({
                heading: 'Sukses',
                text: @js(session('success')),
                variant: 'success'
            })
        })
    </script>
@endif
@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Flux.toast({
                heading: 'Error',
                text: @js(session('error')),
                variant: 'danger'
            })
        })
    </script>
@endif