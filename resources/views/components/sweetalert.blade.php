<script type="text/javascript" src="{{ web_resource_url('assets/js/sweetalert2.js') }}"></script>
<script>
    function confirm_alert(title = 'Are you sure?', text = "You won't be able to revert this!", confirmText = 'Yes, Delete!', icon = 'warning') {
        return Swal.fire({
            title,
            text,
            icon,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmText
        });
    }
</script>
