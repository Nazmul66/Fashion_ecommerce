    <!-- Layout wrapper -->
     @include('backend.includes.meta-tags')
    <!-- Layout wrapper -->


  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

        <!-- sidebar section -->
          @include('backend.includes.sidebar')
        <!-- / sidebar section -->

        <!-- Layout container -->
        <div class="layout-page">

          <!-- Navbar -->
             @include('backend.includes.navbar')
          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">

            <div class="container-xxl flex-grow-1 container-p-y">

                 <!-- Content -->
                     @yield('body-content')
                <!-- / Content -->
                
            </div>

            <!-- Footer -->
            @include('backend.includes.footer')
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
     @include('backend.includes.scripts')
  </body>
</html>
