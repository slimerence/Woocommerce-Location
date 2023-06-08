jQuery(document).ready((t) => {
    t.noConflict(),
        t("#select_location").on("change", function (e) {
            let o = t(this).find("option:selected").val();
            -1 == o && t("#wcmlim_get_direction_for_location").hide(), t("#wcmlim_get_direction_for_location").length > 0 && t("#wcmlim_get_direction_for_location").hide();
            var i = t("#select_location").find(":selected").attr("data-lc-address"),
                c = atob(i);
            t('<a id="wcmlim_get_direction_for_location" target="_blank" href="https://www.google.com/maps?saddr=&daddr=' + c + '">Get Direction</a>').insertAfter(" #globMsg");
        });
});
jQuery(document).ready(function() {
    jQuery("select#select_location").change();
});
