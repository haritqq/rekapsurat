<script>
    document.querySelectorAll('.dropdown-toggle').forEach(button => {
        button.addEventListener('click', function () {
            // Mencari semua elemen collapse kecuali yang sedang diklik
            const targetId = this.getAttribute('href');
            const allCollapses = document.querySelectorAll('.collapse');
            
            allCollapses.forEach(collapse => {
                if ('#' + collapse.id !== targetId) {
                    const bsCollapse = bootstrap.Collapse.getInstance(collapse);
                    if (bsCollapse) {
                        bsCollapse.hide();
                    }
                }
            });
        });
    });
</script>