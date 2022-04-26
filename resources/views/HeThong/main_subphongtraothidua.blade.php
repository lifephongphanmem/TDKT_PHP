<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="fas fa-folder"></i>
        </span>
        <span class="menu-text font-weight-bold">Phong trào thi đua</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/PhongTraoThiDua/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Danh sách phong trào thi đua</span>
                </a>
            </li>
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/HoSoThiDua/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Tạo lập hồ sơ đăng ký thi đua</span>
                </a>
            </li>

            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/XetDuyetHoSoThiDua/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Duyệt hồ sơ đăng ký thi đua</span>
                </a>
            </li>
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/KhenThuongHoSoThiDua/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Khen thưởng phong trào thi đua</span>
                </a>
            </li>
        </ul>
    </div>
</li>
