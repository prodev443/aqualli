<script>
    function updateThemeSetting(id) {
        if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
            $("html").removeAttr("dir");
            $("#dark-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', '<?=base_url('assets/css/bootstrap.min.css')?>');
            $("#app-style").attr('href', '<?=base_url('assets/css/app.min.css')?>');
            sessionStorage.setItem("is_visited", "light-mode-switch");
        } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
            $("html").removeAttr("dir");
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', '<?=base_url('assets/css/bootstrap-dark.min.css')?>');
            $("#app-style").attr('href', '<?=base_url('assets/css/app-dark.min.css')?>');
            sessionStorage.setItem("is_visited", "dark-mode-switch");
        } else if ($("#rtl-mode-switch").prop("checked") == true && id === "rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            $("#dark-rtl-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', '<?=base_url('assets/css/bootstrap-rtl.min.css')?>');
            $("#app-style").attr('href', '<?=base_url('assets/css/app-rtl.min.css')?>');
            $("html").attr("dir", 'rtl');
            sessionStorage.setItem("is_visited", "rtl-mode-switch");
        } else if ($("#dark-rtl-mode-switch").prop("checked") == true && id === "dark-rtl-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $("#rtl-mode-switch").prop("checked", false);
            $("#dark-mode-switch").prop("checked", false);
            $("#bootstrap-style").attr('href', '<?=base_url('assets/css/bootstrap-dark-rtl.min.css')?>');
            $("#app-style").attr('href', '<?=base_url('assets/css/app-dark-rtl.min.css')?>');
            $("html").attr("dir", 'rtl');
            sessionStorage.setItem("is_visited", "dark-rtl-mode-switch");
        }

    }
</script>