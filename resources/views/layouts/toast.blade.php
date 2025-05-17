<script>
    // Cấu hình mặc định cho Toastr
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000,
        positionClass: "toast-top-right",
        preventDuplicates: false
    };

    // // Helper function để hiển thị thông báo
    // function showToast(type, message) {
    //     switch (type) {
    //         case 'success':
    //             toastr.success(message);
    //             break;
    //         case 'error':
    //             toastr.error(message);
    //             break;
    //         case 'info':
    //             toastr.info(message);
    //             break;
    //         case 'warning':
    //             toastr.warning(message);
    //             break;
    //         default:
    //             toastr.info(message);
    //     }
    // }

    $(document).ready(function() {
        // Kiểm tra xem đã hiển thị thông báo chào mừng trong phiên này chưa
        var welcomeShown = sessionStorage.getItem('welcomeMessageShown');

        // Nếu chưa hiển thị thông báo chào mừng
        if (!welcomeShown) {
            setTimeout(function() {
                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 4000
                };
                toastr.success("Xin chào {{ Auth::user()->hoten ?? '' }}", "Quản lý thiết bị");

                // Đánh dấu đã hiển thị thông báo chào mừng
                sessionStorage.setItem('welcomeMessageShown', 'true');
            }, 1300);
        }
    });
</script>

<!-- Hiển thị thông báo từ session flash -->
@if(session('success')&& session('title'))
<script>
    toastr.success("{{session('success') }}", "{{ session('title') }}");
</script>
@endif

@if(session('error') && session('title'))
<script>
    toastr.error("{{ session('error') }}", "{{ session('title') }}");
</script>
@endif

@if(session('info') && session('title'))
<script>
    toastr.info("session('info') ", "{{ session('title') }}");
</script>
@endif

@if(session('warning')&& session('title'))
<script>
    toastr.warning("session('warning') ", "{{ session('title') }}");
</script>
@endif

<!-- Hiển thị lỗi validation -->
@if($errors->any())
@foreach($errors -> all() as $error)
<script>
    toastr.error("{{ $error }}");
</script>
@endforeach
@endif