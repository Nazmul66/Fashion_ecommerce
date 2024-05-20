 <!-- build:js assets/vendor/js/core.js -->
 <script src="{{ asset('public/backend/assets/vendor/libs/jquery/jquery.js') }}"></script>
 <script src="{{ asset('public/backend/assets/vendor/libs/popper/popper.js') }}"></script>
 <script src="{{ asset('public/backend/assets/vendor/js/bootstrap.js') }}"></script>
 <script src="{{ asset('public/backend/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
 <script src="{{ asset('https://cdn.datatables.net/2.0.7/js/dataTables.min.js') }}"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


 <script src="{{ asset('public/backend/assets/vendor/js/menu.js') }}"></script>
 <!-- endbuild -->

<!-- Helpers -->
<script src="{{ asset('public/backend/assets/vendor/js/helpers.js') }}"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('public/backend/assets/js/config.js') }}"></script>

 <!-- Vendors JS -->
 <script src="{{ asset('public/backend/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

 <!-- Main JS -->
 <script src="{{ asset('public/backend/assets/js/main.js') }}"></script>
 <script src="{{ asset('public/backend/assets/js/custom.js') }}"></script>

 <!-- Page JS -->
 <script src="{{ asset('public/backend/assets/js/dashboards-analytics.js') }}"></script>

 <!-- Place this tag in your head or just before your close body tag. -->
 <script async defer src="https://buttons.github.io/buttons.js"></script>

 @stack('script')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
