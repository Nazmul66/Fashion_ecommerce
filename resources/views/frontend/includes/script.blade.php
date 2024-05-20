<!-- Plugins JS File -->
<script src="{{ asset('public/frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.hoverIntent.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/superfish.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/wNumb.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/bootstrap-input-spinner.js') }}"></script>
<script src="{{ asset('public/frontend/assets/js/nouislider.min.js') }}"></script>
<!-- Main JS File -->
<script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>

@stack('scripts')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
