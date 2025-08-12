import "./bootstrap";
import "bootstrap";

// Enhanced Admin Panel JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
    );
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert:not(.alert-permanent)");
    alerts.forEach((alert) => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Enhanced table row highlighting
    const tableRows = document.querySelectorAll(".table tbody tr");
    tableRows.forEach((row) => {
        row.addEventListener("mouseenter", function () {
            this.style.backgroundColor = "rgba(30, 58, 138, 0.05)";
        });

        row.addEventListener("mouseleave", function () {
            this.style.backgroundColor = "";
        });
    });

    // Enhanced form validation feedback
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML =
                    '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';

                // Re-enable after 3 seconds to prevent permanent disable on validation errors
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 3000);
            }
        });
    });

    // Enhanced search functionality with debounce
    const searchInputs = document.querySelectorAll(
        'input[type="search"], input[name="search"]'
    );
    searchInputs.forEach((input) => {
        let timeout;
        input.addEventListener("input", function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                // You can add auto-search functionality here
                console.log("Search query:", this.value);
            }, 500);
        });
    });

    // Enhanced file upload preview
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach((input) => {
        input.addEventListener("change", function (e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith("image/")) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Create preview if preview container exists
                    const previewContainer = input.parentElement.querySelector(
                        ".image-preview-container"
                    );
                    if (previewContainer) {
                        previewContainer.innerHTML = `
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        `;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Enhanced copy to clipboard functionality
    window.copyToken = function () {
        const tokenInput = document.getElementById("adminToken");
        if (tokenInput) {
            tokenInput.select();
            tokenInput.setSelectionRange(0, 99999); // For mobile devices

            try {
                document.execCommand("copy");
                showToast("Token berhasil disalin!", "success");
            } catch (err) {
                showToast("Gagal menyalin token", "error");
            }
        }
    };

    // Enhanced toast notifications
    window.showToast = function (message, type = "info") {
        // Remove existing toasts
        const existingToasts = document.querySelectorAll(".custom-toast");
        existingToasts.forEach((toast) => toast.remove());

        const toast = document.createElement("div");
        toast.className = `custom-toast alert alert-${
            type === "error" ? "danger" : type
        } alert-dismissible fade show position-fixed`;
        toast.style.cssText =
            "top: 20px; right: 20px; z-index: 9999; min-width: 250px;";
        toast.innerHTML = `
            <i class="fas fa-${
                type === "success"
                    ? "check-circle"
                    : type === "error"
                    ? "exclamation-circle"
                    : "info-circle"
            } me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(toast);
            bsAlert.close();
        }, 3000);
    };

    // Enhanced price formatting for Indonesian Rupiah
    const priceInputs = document.querySelectorAll(
        '.price-input, input[name*="harga"]'
    );
    priceInputs.forEach((input) => {
        input.addEventListener("input", function (e) {
            // Remove non-numeric characters
            let value = e.target.value.replace(/[^\d]/g, "");

            // Format with thousand separators
            if (value) {
                const formatted = parseInt(value).toLocaleString("id-ID");
                e.target.value = formatted;
            }
        });

        // Convert back to numeric on form submit
        input.closest("form")?.addEventListener("submit", function () {
            input.value = input.value.replace(/[^\d]/g, "");
        });
    });

    // Enhanced data tables with sorting indicators
    const sortableHeaders = document.querySelectorAll("th[data-sort]");
    sortableHeaders.forEach((header) => {
        header.style.cursor = "pointer";
        header.addEventListener("click", function () {
            // Add sorting logic here if needed
            console.log("Sort by:", this.dataset.sort);
        });
    });

    // Enhanced image modal for vehicle photos
    const vehicleImages = document.querySelectorAll(
        ".vehicle-image, .img-thumbnail"
    );
    vehicleImages.forEach((img) => {
        img.addEventListener("click", function () {
            createImageModal(this.src, this.alt);
        });
    });

    function createImageModal(src, alt) {
        const modal = document.createElement("div");
        modal.className = "modal fade";
        modal.innerHTML = `
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${alt || "Foto Kendaraan"}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="${src}" alt="${alt}" class="img-fluid">
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();

        modal.addEventListener("hidden.bs.modal", function () {
            modal.remove();
        });
    }

    // Enhanced confirmation dialogs
    const deleteButtons = document.querySelectorAll(
        'button[onclick*="confirm"], a[onclick*="confirm"]'
    );
    deleteButtons.forEach((button) => {
        const originalOnclick = button.getAttribute("onclick");
        button.removeAttribute("onclick");

        button.addEventListener("click", function (e) {
            e.preventDefault();

            const isDelete =
                originalOnclick.includes("hapus") ||
                originalOnclick.includes("delete");
            const message = isDelete
                ? "Apakah Anda yakin ingin menghapus item ini? Tindakan ini tidak dapat dibatalkan."
                : "Apakah Anda yakin ingin melanjutkan?";

            if (confirm(message)) {
                if (button.tagName === "BUTTON") {
                    button.closest("form")?.submit();
                } else {
                    window.location.href = button.href;
                }
            }
        });
    });

    // Add loading states to navigation
    const navLinks = document.querySelectorAll(".menu-link, .nav-link");
    navLinks.forEach((link) => {
        link.addEventListener("click", function () {
            if (!this.href.includes("#")) {
                const icon = this.querySelector("i");
                if (icon) {
                    icon.className = "fas fa-spinner fa-spin";
                }
            }
        });
    });
});

// Utility functions
window.adminUtils = {
    formatPrice: function (price) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(price);
    },

    formatDate: function (date) {
        return new Intl.DateTimeFormat("id-ID", {
            year: "numeric",
            month: "long",
            day: "numeric",
        }).format(new Date(date));
    },

    showLoading: function (element) {
        element.disabled = true;
        element.innerHTML =
            '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
    },

    hideLoading: function (element, originalText) {
        element.disabled = false;
        element.innerHTML = originalText;
    },
};
