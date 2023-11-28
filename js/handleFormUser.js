import { toast } from "../js/handleToast.js";

// handle in form login
function handleFormLogin() {
  const formLogin = document.getElementById("formLogin");
  formLogin
    .querySelectorAll(`input:not([type="submit"]).form-control`)
    .forEach((element, index) => {
      element.addEventListener("focus", function () {
        element.select();
      });
    });
  formLogin
    .querySelectorAll(`input:not([type="submit"]).form-control`)
    .forEach((element, index) => {
      element.addEventListener("input", () => {
        document
          .querySelectorAll(".form-group")
          [index].classList.remove("error");
        document
          .querySelectorAll(".messageError")
          [index].classList.remove("error");
      });
    });

  formLogin.addEventListener("submit", function (event) {
    event.preventDefault();
    const formdata = new FormData(this);
    formdata.append("Login", true);

    $.ajax({
      type: "post",
      data: formdata,
      url: "./include/LoginForm.php",
      processData: false,
      contentType: false,
      success: function (response) {
        const parser = new DOMParser();
        const html = parser.parseFromString(response, "text/html");
        const ModalDialog = html.querySelector(".modal-dialog");
        $("#loginModal").html(ModalDialog);
        checkLoginStatus();
        handleFormLogin();
      },
    });
  });
}

handleFormLogin();

window.addEventListener("DOMContentLoaded", () => {
  const loginStatus = sessionStorage.getItem("loginStatus");
  const registerStatus = sessionStorage.getItem("registerStatus");
  sessionStorage.removeItem("loginStatus");
  sessionStorage.removeItem("registerStatus");
  if (loginStatus === "success") {
    toast({
      title: "Thành công!",
      message: "Đăng nhập thành công.",
    });
  }
  if (registerStatus === "success") {
    toast({
      title: "Thành công!",
      message: "Đăng ký tài khoản thành công.",
      duration: 1500,
    });
  }
});

function checkLoginStatus() {
  var isLogin = getCookie("logged_in");
  if (isLogin === "true") {
    $(".wrap_loader").addClass("active");
    $(".overlay").addClass("show");
    sessionStorage.setItem("loginStatus", "success");
    setTimeout(function () {
      // Sau khi trì hoãn, ẩn hiệu ứng loading
      $(".wrap_loader").removeClass("active");
      $(".overlay").removeClass("show");

      // Khôi phục trạng thái ban đầu của nút submit
      $("input[type=submit]").prop("disabled", false);
      // Tải lại trang
      location.reload();
    }, 3000);
  }
}

document.querySelector(".logout") &&
  document.querySelector(".logout").addEventListener("click", function (event) {
    event.preventDefault();
    let formdata = new FormData();
    formdata.append("logout", true);
    $.ajax({
      type: "post",
      data: formdata,
      url: "./include/header.php",
      processData: false,
      contentType: false,
      success: function (response) {
        var statusAcc = getCookie("islogout");
        if (statusAcc === "true") {
          location.reload();
        }
      },
    });
  });

// --handle in form login

// get cookie
function getCookie(name) {
  var cookieName = name + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  document.cookie = name + "=; expires=Hoa, 01 Jan 1970 00:00:00 UTC; path=/;";
  var cookieArray = decodedCookie.split(";");
  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i];
    while (cookie.charAt(0) === " ") {
      cookie = cookie.substring(1);
    }
    if (cookie.indexOf(cookieName) === 0) {
      return cookie.substring(cookieName.length, cookie.length);
    }
  }
  return "";
}
// --get cookie

// handle in form Register
function handlInputCheckFormRegister() {
  const formRegister = document.getElementById("formRegister");

  formRegister
    .querySelectorAll(`input:not([type="submit"]).form-control.Inputcheck`)
    .forEach((element, index) => {
      element.addEventListener("focusin", function () {
        element.select();
        const post = Array.from(
          formRegister.querySelectorAll(
            `input:not([type="submit"]).form-control`
          )
        ).indexOf(element);

        element.addEventListener("input", () => {
          formRegister
            .querySelectorAll(".form-group")
            [post].classList.remove("error");
          formRegister
            .querySelectorAll(".form-group")
            [post].classList.remove("success");

          formRegister
            .querySelectorAll(".form-group")
            [index]?.querySelector(".messageError")
            ?.classList.remove("error");
        });
      });
    });

  document.querySelectorAll("input.Inputcheck").forEach((element, index) => {
    element.addEventListener("blur", function (event) {
      // bỏ qua việc chọn toàn bộ nội dung trong form
      window.getSelection().removeAllRanges();

      if (this.value) {
        const formdata = new FormData();

        document
          .querySelectorAll("input.Inputcheck")
          .forEach(function (element) {
            if (element.value) {
              formdata.append(`${element.name}`, `${element.value.trim()}`);
            }
          });

        hadleAjaxFormRegister(formdata, "");
      }
    });
  });
}

//call method run methos form register
handlInputCheckFormRegister();

function hadleAjaxFormRegister(formdata, type = "form") {
  $.ajax({
    type: "post",
    data: formdata,
    url: "./include/RegisterForm.php",
    processData: false,
    contentType: false,
    success: function (response) {
      const parser = new DOMParser();
      const html = parser.parseFromString(response, "text/html");
      const ModalDialog = html.querySelector(".modal-dialog");
      $("#registerModal").html("");
      $("#registerModal").html(ModalDialog);
      if (type === "form") {
        checkRegisterStatus();
      }

      handleFormRegister();
      handlInputCheckFormRegister();
    },
  });
}

function handleFormRegister() {
  document
    .getElementById("formRegister")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formdata = new FormData(this);
      formdata.append("Register", true);
      hadleAjaxFormRegister(formdata);
    });
}

function checkRegisterStatus() {
  var isRegister = getCookie("register");
  console.log("hello");
  if (isRegister === "success") {
    $(".wrap_loader").addClass("active");
    $(".overlay").addClass("show");
    sessionStorage.setItem("registerStatus", "success");
    setTimeout(function () {
      // Sau khi trì hoãn, ẩn hiệu ứng loading
      $(".wrap_loader").removeClass("active");
      $(".overlay").removeClass("show");

      // Khôi phục trạng thái ban đầu của nút submit
      $("input[type=submit]").prop("disabled", false);
      // Tải lại trang
      location.reload();
    }, 3000);
  } else {
    toast({
      title: "Thất bại",
      message: "Đăng ký tài khoản thất bại.",
      type: "error",
      duration: 1500,
    });
  }
}

// handleFormRegister();

// --handle in form Register

// for (const [key, value] of formdata.entries()) {
//   console.log(key + "=" + value);
// }
