// Toast function
export function toast({
  title = "",
  message = "",
  type = "success",
  duration = 3000,
}) {
  const main = document.getElementById("toast");
  if (main) {
    const toast = document.createElement("div");

    // Auto remove toast
    const autoRemoveId = setTimeout(function () {
      main.removeChild(toast);
    }, duration + 1500);

    // Remove toast when clicked
    toast.onclick = function (e) {
      if (e.target.closest(".toast__close")) {
        e.preventDefault();
        toast.style.animation = `fadeOut linear 1.5s 0.2s forwards`;
        setTimeout(() => {
          main.removeChild(toast);
          clearTimeout(autoRemoveId);
        }, 1200);
      }
    };

    const icons = {
      success: "fa-sharp fa-solid fa-circle-check",
      error: "fa-sharp fa-solid fa-circle-exclamation",
      warning: "fa-sharp fa-solid fa-circle-exclamation",
    };
    const icon = icons[type];
    const delay = (duration / 1000).toFixed(2);

    toast.classList.add("toast", `toast--${type}`);
    toast.style.animation = `slideInLeft ease .3s, fadeOut linear 1s ${delay}s forwards`;

    toast.innerHTML = `
                    <div class="toast__icon">
                        <i class="${icon}"></i>
                    </div>
                    <div class="toast__content">
                        <p class="toast__type">${title}</p>
                        <p class="toast__message">${message}</p>
                    </div>
                    <div class="toast__close">
                        <i class="fa-light fa-xmark"></i>
                    </div>
                  `;
    main.appendChild(toast);
  }
}
