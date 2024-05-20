
@include('frontend.includes.meta-tags')

<body>
    <div class="page-wrapper">
        <!-- header start -->
          @include('frontend.includes.header')
        <!-- header end -->

        <main class="main">

            <!-- Body Content start -->
                @yield('body-content')
            <!-- Body Content end -->
        </main>

        <!-- footer start -->
           @include('frontend.includes.footer')
        <!-- footer end -->
    </div>

    @include('frontend.includes.others')

    <!-- script start -->
       @include('frontend.includes.script')
    <!-- footer end -->

</body>
</html>
