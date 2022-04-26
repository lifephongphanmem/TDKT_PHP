<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <i class="fas fa-folder"></i>
        </span>
        <span class="menu-text font-weight-bold">Khen thưởng khác</span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item" aria-haspopup="true">
                <a href="{{ url('/CumKhoiThiDua/DanhSach/ThongTin') }}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text font-weight-bold">Hiệp y khen thưởng</span>
                </a>
            </li>
            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Khen thưởng thời kỳ kháng chiến</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">															
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/ChongPhap/CaNhan')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Khen thưởng kháng chiến chống Pháp (cá nhân)</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/ChongMy/CaNhan')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Khen thưởng kháng chiến chống Mỹ (cá nhân)</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/ChongMy/GiaDinh')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Khen thưởng gia đình chống Mỹ</span>
                            </a>
                        </li>

                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/BangKhen/ThuThuong')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Bằng khen thủ tướng</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/BangKhen/Tinh')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Bằng khen chủ tịch UBND tỉnh</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{url('/KhenThuongKhangChien/KyNiemChuong')}}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text font-weight-bold">Kỷ niệm chương</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                <a href="javascript:;" class="menu-link menu-toggle">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Khen cao</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="menu-submenu">
                    <i class="menu-arrow"></i>
                    <ul class="menu-subnav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ url('/CumKhoiThiDua/HoSoKhenThuong/ThongTin') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Tạo hồ sơ đề nghị khen thưởng</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ url('/CumKhoiThiDua/XetDuyetHoSoKhenThuong/ThongTin') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Duyệt hồ sơ đề nghị khen thưởng</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="{{ url('/CumKhoiThiDua/KhenThuongHoSoKhenThuong/ThongTin') }}" class="menu-link">
                                <i class="menu-bullet menu-bullet-dot">
                                    <span></span>
                                </i>
                                <span class="menu-text">Khen thưởng hồ sơ đề nghị khen thưởng</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</li>
