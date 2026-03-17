@if (session('status_success'))
    <div class="alert alert-success" role="status" data-auto-dismiss="5000">
        {{ session('status_success') }}
    </div>
@endif

@if (session('status_error'))
    <div class="alert alert-error" role="alert" data-auto-dismiss="5000">
        {{ session('status_error') }}
    </div>
@endif

<script>
    document.querySelectorAll('[data-auto-dismiss]').forEach(function (alertBox) {
        var delay = Number(alertBox.getAttribute('data-auto-dismiss')) || 5000;

        window.setTimeout(function () {
            alertBox.classList.add('alert-hiding');

            window.setTimeout(function () {
                alertBox.remove();
            }, 320);
        }, delay);
    });
</script>
