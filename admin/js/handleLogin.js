function showMessageError(
  index = 2,
  message = "Tên đăng nhập hoặc mật khẩu sai"
) {
  document.querySelectorAll(".messageError")[index].classList.add("error");
  document.querySelectorAll(".messageError")[index].innerText = message;
}

function HideMessageError(index, message = "") {
  document.querySelectorAll(".messageError")[index].innerText = message;
  document.querySelectorAll(".messageError")[index].classList.remove("error");
}

document
  .getElementById("fromLogin")
  .addEventListener("submit", function (event) {
    let formdata = new FormData(this);
    let check = true;
    Array.from(formdata.entries()).forEach((element, index) => {
      let [key, value] = element;
      if (value === "") {
        check = false;
        key === "username" && showMessageError(index, "Tên đăng nhập trống");
        key === "password" && showMessageError(index, "Mật khẩu trống");
      } else {
        HideMessageError(index);
      }
    });

    if (check) {
      formdata.append("btnLogin", true);
      $.ajax({
        type: "post",
        data: formdata,
        url: "login.php",
        processData: false,
        contentType: false,
        success: function (response) {},
      });
    } else {
      event.preventDefault();
    }
  });
