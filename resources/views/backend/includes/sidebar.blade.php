
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <!-- Dashboard -->
      <li class="menu-item  active">
        <a href="{{ route('dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Analytics">Dashboard</div>
        </a>
      </li>

      <!-- Layouts -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-layout"></i>
          <div data-i18n="Layouts">Layouts </div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{ route('category.manage') }}" class="menu-link">
              <div data-i18n="Container">Category</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="{{ route('subCategory.manage') }}" class="menu-link">
              <div data-i18n="Container">Sub Category</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="{{ route('brand.manage') }}" class="menu-link">
              <div data-i18n="Container">Brands</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="{{ route('discount.manage') }}" class="menu-link">
              <div data-i18n="Container">Discount</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="{{ route('color.manage') }}" class="menu-link">
              <div data-i18n="Container">Colors</div>
            </a>
          </li>

          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              {{-- <i class="menu-icon tf-icons bx bx-layout"></i> --}}
              <div data-i18n="Layouts">Product</div>
            </a>

                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('product.manage') }}" class="menu-link">
                          <div data-i18n="Container">-- Manage Product</div>
                        </a>
                    </li>

                    <li class="menu-item">
                        <a href="{{ route('product.create') }}" class="menu-link">
                          <div data-i18n="Container">-- Create Product</div>
                        </a>
                    </li>
                </ul>
          </li>

        </ul>
      </li>

      @if( Auth::user()->role === 3 )
        <!-- Optional -->
        <li class="menu-header small text-uppercase"><span class="menu-header-text">Optional</span></li>

          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <i class="menu-icon tf-icons bx bx-layout"></i>
              <div data-i18n="Layouts">Settings</div>
            </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="" class="menu-link">
                    <div data-i18n="Container">Website Setting</div>
                  </a>
                </li>

                <li class="menu-item ">
                  <a href="{{ route('admin.list') }}" class="menu-link">
                    <div data-i18n="Container">Create Admin</div>
                  </a>
                </li>
            </ul>
          </li>
       @endif
    </ul>
  </aside>
