setTimeout(() => {
    const alert = document.getElementById("success-alert");
    if (alert) {
        alert.classList.remove("show");
        alert.classList.add("fade");

        setTimeout(() => {
            alert.remove();
        }, 300);
    }
}, 1000); // 1000ms = 1 detik
