!(function (e) {
    e(document).ready(function () {
        let e = jQuery("body");
        if ("undefined" != typeof multi_inventory) {
            let i = multi_inventory.isUserLoggedIn,
                t = multi_inventory.loginURL,
                s = multi_inventory.isUserAdmin,
                n = window.sessionStorage,
                o = multi_inventory.resUserSLK;
            if (i || e.hasClass("login-action-login")) {
                if (s) {
                    n.setItem("rsula", '<div id="restrict_user_logged_in_as_admin" style="display:none;"></div>');
                    return;
                }
                !(function e(i, t, s) {
                    let n = new Date();
                    if (s) {
                        n.setTime(n.getTime() + 864e5 * s);
                        var o = `; expires=${n.toUTCString()}`;
                    } else {
                        n.setTime(n.getTime() + 864e5);
                        var o = `; expires=${n.toUTCString()}`;
                    }
                    document.cookie = `${i}=${t}${o};path=/`;
                })("wcmlim_selected_location", o);
            } else {
                let r = `<div id="restrict_user_not_logged_in" style="display:none;"><div class="notice notice-warning"><p>You must be logged in to purchase this product.<a class="button" href="${t}" title="Login">Login</a></p></div></div>`;
                n.setItem("rsnlc", r);
            }
        }
    });
})(jQuery);
