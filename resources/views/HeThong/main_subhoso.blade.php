<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="fas fa-folder"></i>
        </span>
        <span class="menu-text font-weight-bold">Quản lý hồ sơ</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/DangKyDanhHieu/HoSo/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hồ sơ đăng ký thi đua</span>
                </a>
            </li>

            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/HoSoThiDua/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hồ sơ đăng ký phong trào thi đua</span>
                </a>
            </li>

            <li class="menu-item" aria-haspopup="true">
                <a href="{{url('/KhenThuongCongTrang/HoSoKhenThuong/ThongTin')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hồ sơ đề nghị khen thưởng theo công trạng</span>
                </a>
            </li>

            <li class="menu-item" aria-haspopup="true">
                <a href="{{url('/KhenThuongDotXuat/HoSo/ThongTin')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hồ sơ đề nghị khen thưởng đột xuất</span>
                </a>
            </li>
        </ul>
    </div>
</li>
