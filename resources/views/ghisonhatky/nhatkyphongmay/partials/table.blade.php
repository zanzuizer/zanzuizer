<div class="ibox-content">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-nkphongmay">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Ngày</th>
                    <th>Giờ vào</th>
                    <th>Giờ ra</th>
                    <th>Mục đích sử dụng</th>
                    <th>Tình trạng trước khi sử dụng</th>
                    <th>Tình trạng sau khi sử dụng</th>
                    <th>Giáo viên sử dụng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script>
    $(document).ready(function() {
        console.log("ready");

        function initPhongAutocomplete(inputSelector, options = {}) {
            const $input = $(inputSelector);
            $input.autocomplete({
                source: options.source || function(request, response) {
                    $.ajax({
                        url: "{{ route('nhatkyphongmay.search-phong') }}",
                        method: "GET",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response(data.map(function(item) {
                                return {
                                    label: item.maphong + " (" + item.tenphong + ")",
                                    id: item.id,
                                    mays: item.mays,
                                    tenphong: item.tenphong,
                                    tengvql: item.tengvql,
                                };
                            }));
                        },
                        error: function(xhr, status, error) {
                            console.error("Error fetching data:", error);
                        }
                    });
                },
                appendTo: options.appendTo || ".form-group.autocomplete",
                select: options.select,
                change: options.change,
            });
            const updateAutocompleteWidth = () => {
                const $menu = $input.autocomplete("widget");
                const inputWidth = $input.outerWidth();
                $menu.css("width", inputWidth + "px");
            };
            $input.on("autocompleteopen", updateAutocompleteWidth);
            $(window).on("resize", updateAutocompleteWidth);
        }
        // Khởi tạo autocomplete cho trường tìm kiếm phòng máy
        initPhongAutocomplete("#phongSearch", {
            select: function(event, ui) {
                console.log("Selected item:", ui);
                $("#phongSearch").val(ui.item.label);
                sessionStorage.setItem("id", ui.item.id);
                sessionStorage.setItem("tenphong", ui.item.tenphong);
                $("#gvql").text(ui.item.tengvql);
                if (ui.item.mays.length > 0) {
                    $("#noMap").addClass("hidden");
                    $("#hasMap").removeClass("hidden");
                    roomMap(ui.item.mays);
                } else {
                    $("#noMap").removeClass("hidden");
                    $("#hasMap").addClass("hidden");
                }
                if (table) {
                    table.ajax.reload();
                }
                return false;
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $("#phongSearch").val("");
                    sessionStorage.removeItem("id");
                    sessionStorage.removeItem("tenphong");
                    $("#gvql").text("");
                    $("#noMap").removeClass("hidden");
                    $("#hasMap").addClass("hidden");
                }
            }
        });
        initPhongAutocomplete("#phongSearchCreate", {
            appendTo: ".form-group.autocomplete",
            select: function(event, ui) {
                $("#phongSearchCreate").val(ui.item.label);
                return false;
            },
        });
        initPhongAutocomplete("#edit_phong", {
            appendTo: ".form-group.autocomplete",
            select: function(event, ui) {
                $("#edit_phong").val(ui.item.label);
                return false;
            },
        });

        // Khởi tạo DataTable
        let table = $('.dataTables-nkphongmay').DataTable({
            responsive: true,
            serverSide: false,
            ajax: {
                url: "{{ route('nhatkyphongmay.loadTable') }}",
                type: 'GET',
                data: function(d) {
                    d.idphong = sessionStorage.getItem("id") || $('#phongSearch').val() || '';
                    d.idhocky = $('#hockySearch').val() || '';
                    console.log("idphong:", d.idphong, "idhocky:", d.idhocky);
                },
                dataSrc: 'data',
                dataFilter: function(data) {
                    let json = JSON.parse(data);
                    if (!json.data || !Array.isArray(json.data)) {
                        console.warn("Dữ liệu không hợp lệ, trả về mảng rỗng.");
                        json.data = [];
                    }
                    return JSON.stringify(json);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", {
                        status: status,
                        error: error,
                        response: xhr.responseText
                    });
                    alert("Không thể tải dữ liệu. Vui lòng thử lại.");
                }
            },
            initComplete: function(settings, json) {
                console.log("Data loaded:", json);
            },
            columns: [{
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: 'ngay',
                    render: function(data, type, row) {
                        return data && moment(data).isValid() ? moment(data).format('DD/MM/YYYY') : 'Không có';
                    }
                },
                {
                    data: 'giovao',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'giora',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'mucdichsd',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'tinhtrangtruoc',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'tinhtrangsau',
                    render: function(data) {
                        return data || 'Không có';
                    }
                },
                {
                    data: 'taikhoan.hoten',
                    render: function(data, type, row) {
                        return row.taikhoan && row.taikhoan.hoten ? row.taikhoan.hoten : 'Không có';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                        <a href="#" class="btn btn-warning btn-sm edit-btn"
                            data-tooltip="Cập nhật"
                            data-id="${row.id}"
                            data-toggle="modal"
                            data-target="#editPMModal">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <a href="#" class="btn btn-danger btn-sm delete-btn"
                            data-tooltip="Xóa"
                            data-id="${row.id}"
                            data-toggle="modal"
                            data-target="#deletePMModal">
                            <i class="fa fa-trash"></i>
                        </a>
                    `;
                    }
                }
            ],
            order: [], // Không sắp xếp mặc định
            columnDefs: [{
                targets: [0, 8],
                orderable: false,
                className: 'text-center'
            }],
            // Tính toán lại STT dựa trên trang hiện tại
            drawCallback: function(settings) {
                var api = this.api();
                var startIndex = api.context[0]._iDisplayStart;

                api.column(0, {
                    page: 'current'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = startIndex + i + 1;
                });
            },
            dom: "<'row mb-3'" +
                "<'col-md-4'l>" + // show entries
                "<'col-md-4 text-center'B>" + // buttons
                "<'col-md-4 d-flex justify-content-end'f>" + // search về phải
                ">" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [{
                    extend: 'copyHtml5'
                },
                {
                    extend: 'excel'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'pdf'
                }
            ],
        });
        // Tạo sơ đồ phòng máy
        function roomMap(totalMachines) {
            const container = document.getElementById("hasMap");
            container.innerHTML = '';
            for (let i = 1; i <= totalMachines.length; i++) {
                const pcData = totalMachines[i - 1];
                const pc = document.createElement("button");
                pc.className = "pc status_pc";
                pc.setAttribute("data-pc", JSON.stringify(pcData));
                pc.setAttribute("data-toggle", "modal");
                pc.setAttribute("data-target", "#modalUpdateStatus");
                pc.textContent = ("0" + i).slice(-2);
                // Thêm lớp CSS dựa trên tình trạng máy
                if (pcData.tinhtrang === "Hư hỏng") {
                    pc.classList.add("broken");
                    pc.setAttribute("title", "Không hoạt động");
                }
                container.appendChild(pc);
            }
        }

        // Xử lý sự kiện thay đổi học kỳ hoặc phòng máy
        $('#hockySearch', '#phongSearch').on('change', function() {
            if (table) {
                table.ajax.reload();
            } else {
                console.error("DataTable chưa được khởi tạo!");
            }
        });
    });
    $(document).on('click', '.status_pc', function() {
        console.log("Modal Update Status clicked");
        let data = JSON.parse(this.getAttribute('data-pc'));
        $('#edit-tentb').val(data.tentb);
        $('#edit-mota').val(data.mota);
        if (data.tinhtrang == "Hư hỏng")
            $('#edit-tinhtrang option[value="Hư hỏng"]').prop('selected', true);
        else
            $('#edit-tinhtrang option[value="Đang sử dụng"]').prop('selected', true);
        $('#edit-ghichu').val(data.ghichu);
        $('#editStatusForm').attr('action', '{{ route("nhatkyphongmay.update-status-pc", ":id") }}'.replace(':id', data.id));
    });

    function formatTime(timeStr) {
        let parts = timeStr.split(':');
        let hour = parts[0].padStart(2, '0');
        return `${hour}:${parts[1]}`;
    }
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        // Lấy thông tin đơn vị qua AJAX
        $.ajax({
            url: '{{ route("nhatkyphongmay.edit", ":id") }}'.replace(':id', id),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Điền thông tin vào form
                $('#edit-phong').val(sessionStorage.getItem('tenphong'));
                $('input[name="giovao"]').val(formatTime(response.nhatky.giovao));
                $('input[name="giora"]').val(formatTime(response.nhatky.giora));
                $('textarea[name="mucdichsd"]').val(response.nhatky.mucdichsd);
                $('textarea[name="tinhtrangtruoc"]').val(response.nhatky.tinhtrangtruoc);
                $('textarea[name="tinhtrangsau"]').val(response.nhatky.tinhtrangsau);
                // Cập nhật action của form
                $('#editForm').attr('action', '{{ route("nhatkyphongmay.update", ":id") }}'.replace(':id', id));
            },
            error: function(xhr) {
                showToast('error', 'Đã xảy ra lỗi khi lấy thông tin nhật ký');
            }
        });
    });
    $(document).on('click', '.delete-btn', function() {
        // Lấy ID từ thuộc tính data-id của nút bấm
        var id = $(this).data('id');
        $('#deleteForm').attr('action', '{{ route("nhatkyphongmay.destroy", ":id") }}'.replace(':id', id));
    });
    $('input[name="giovao"]').each(function() {
        if (this._flatpickr) {
            this._flatpickr.destroy();
        }
        this._flatpickr = flatpickr(this, {
            enableTime: true,
            noCalendar: true, // Ẩn lịch
            dateFormat: "H:i", // Định dạng giờ và phút
            time_24hr: true, // Hiển thị theo giờ 24
            onOpen: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.addEventListener('mousedown', function(e) {
                    e.stopPropagation();
                });
            }
        });
    });
    $('.datePicker').each(function() {
        if (this._flatpickr) {
            this._flatpickr.destroy();
        }
        this._flatpickr = flatpickr(this, {
            dateFormat: 'd/m/Y',
            locale: 'vi',
            maxDate: new Date(),
            defaultDate: new Date(),
            onOpen: function(selectedDates, dateStr, instance) {
                instance.calendarContainer.addEventListener('mousedown', function(e) {
                    e.stopPropagation();
                });
            }
        });
    });
</script>
@endsection