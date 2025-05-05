"use strict";

const LayoutUtils = {
    toggleSidebar(e) {
        e.preventDefault();
        const wrapper = $(".wrapper");
        const miniButton = $(".toggle-sidebar");

        if (wrapper.hasClass("sidebar_minimize")) {
            wrapper.removeClass("sidebar_minimize");
            miniButton.removeClass("toggled");
            miniButton.html('<i class="gg-menu-right"></i>');
        } else {
            wrapper.addClass("sidebar_minimize");
            miniButton.addClass("toggled");
            miniButton.html('<i class="gg-more-vertical-alt"></i>');
        }

        $(window).resize();
    },

    showPassword(button) {
        const inputPassword = $(button).parent().find("input");
        inputPassword.attr(
            "type",
            inputPassword.attr("type") === "password" ? "text" : "password"
        );
    },

    readImageURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                $(input)
                    .parent(".input-file-image")
                    .find(".img-upload-preview")
                    .attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    },
};

// Export for use in other files
window.LayoutUtils = LayoutUtils;
