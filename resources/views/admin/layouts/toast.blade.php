<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('loginSuccessBar');

        if (bar) {
            setTimeout(() => {
                bar.classList.remove('show');
                bar.classList.add('hide');
            }, 2500);
        }
    });
</script>
