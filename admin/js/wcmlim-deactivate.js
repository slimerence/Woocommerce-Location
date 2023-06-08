jQuery(document).ready(($) => {
    $("#deactivate-woocommerce-multi-locations-inventory-management").on("click", function (event) {
        event.preventDefault();
        var modal = document.getElementById("wcmlim_deactivator_popup");
        modal.style.display = "block";
        var span = document.getElementsByClassName("wcmlim-close")[0];
        modal.style.display = "block";
        span.onclick = function () {
            modal.style.display = "none";
        };
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };
    });
    $("#wcmlim_skip_deactive").on("click", function (event) {
        $.ajax({
            url: multi_inventory.ajaxurl,
            type: "POST",
            data: { action: "wcmlim_deactivate_plugin" },
            success(response) {
                location.reload();
            },
        });
    });
    $("#wcmlim_submit_deactive").on("click", function (event) {
        var selected_option = $("input[name= 'wcmlim_feedback_option']:checked").val();
        var UserEmail = $("input[name='wcmlim-user-email']:text").val();
        var Domain = $("input[name='wclim-user-domain']:text").val();
        var CurrentPlugin = $("input[name='wclim-user-plugin']:text").val();
        var msg = "Multilocation Inventory";
        $.ajax({
            url: multi_inventory.ajaxurl,
            type: "POST",
            data: { action: "wcmlim_submit_feedback", selected_option: selected_option, UserEmail: UserEmail, domain: Domain, CurrentPlugin: CurrentPlugin, msg: msg },
            success(response) {
                $("#wcmlim_skip_deactive").click();
            },
        });
    });
});
