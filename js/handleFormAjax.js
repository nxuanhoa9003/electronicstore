import { toast } from "../js/handleToast.js";
// get cookie
function getCookie(name) {
  var cookieName = name + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
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

// submit form without reload page using ajax
document
  .querySelectorAll(".formChangeQuantity")
  .forEach(function (element, index) {
    element.addEventListener("submit", function (event) {
      let formData = new FormData(this);
      const userCode = getCookie("usercode");
      formData.append("usercode", `${userCode}`);

      event.preventDefault();
      $.ajax({
        type: "post",
        data: formData,
        url: "./include/updateSPC.php",
        processData: false,
        contentType: false,
        success: function (response) {
          calculateToTalAmount();
        },
      });
    });
  });
// submit form without reload page using ajax

// change data shopping cart when click button delete product
const RowsShopingCart = document.querySelectorAll(".row_cartsp");
const btnsDeleteProductSC = document.querySelectorAll(".btnDeleteProduct");
const TitleamountProductSC = document.querySelector(".title-shopping-cart");
let amountProductSC =
  TitleamountProductSC &&
  TitleamountProductSC.getAttribute("data-count-product");
document
  .querySelectorAll(".formDeleteProduct")
  .forEach(function (element, index) {
    element.addEventListener("submit", function (event) {
      event.preventDefault();
      let formData = new FormData(this);
      const userCode = getCookie("usercode");
      formData.append("usercode", `${userCode}`);
      formData.append("IsBtnDelete", true);

      $.ajax({
        type: "post",
        data: formData,
        url: "./include/updateSPC.php",
        processData: false,
        contentType: false,
        success: function (response) {
          RowsShopingCart[index].remove();
          calculateToTalAmount();
          TitleamountProductSC.setAttribute(
            "data-count-product",
            --amountProductSC
          );
          TitleamountProductSC.querySelector("span").innerHTML =
            amountProductSC;

          if (amountProductSC > 0) {
            document.querySelectorAll(".row_cartsp").forEach((row, i) => {
              row.querySelector(".ordinal").innerHTML = i + 1;
            });
          }
        },
      });
    });
  });

//   change data shopping cart when click button delete product

// handle data when submit form customer information
document.getElementById("agileinfo_form") &&
  document
    .getElementById("agileinfo_form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const checkLogin = getCookie("usr");
      if (checkLogin) {
        let formData = new FormData(this);
        formData.append("pay", true);
        $.ajax({
          type: "post",
          data: formData,
          url: "./include/updateCustomers.php",
          processData: false,
          contentType: false,
          success: function (response) {
            calculateToTalAmount();
            document.getElementById("agileinfo_form").reset();
            document.querySelector(".Tbody_shoppingCart").innerHTML = "";
            TitleamountProductSC.setAttribute("data-count-product", 0);
            TitleamountProductSC.querySelector("span").innerHTML = 0;
          },
        });
      } else {
        window.scrollTo(0, 1);
        $("#loginModal").modal("show");
        toast({
          title: "Thanh toán thất bại",
          message: "Bạn chưa đăng nhập.",
          type: "warning",
          duration: 1500,
        });
      }
      var request = new XMLHttpRequest();
      request.upload.addEventListener("load", function () {}, false);
    });
//   handle data when submit form customer information

// handle form add product to shopping cart
document.querySelectorAll(".formAddToSPC").forEach((element, index) => {
  element.addEventListener("submit", function (event) {
    // event.preventDefault();
    const checkLogin = getCookie("usr");
    const userCode = getCookie("usercode");
    if (checkLogin) {
      let formData = new FormData(this);
      formData.append("usercode", `${userCode}`);
      formData.append("submitAddSC", true);

      $.ajax({
        type: "post",
        data: formData,
        url: "./include/updateSPC.php",
        processData: false,
        contentType: false,
        success: function (response) {
          calculateToTalAmount();
        },
      });
    } else {
      event.preventDefault();
      window.scrollTo(0, 1);
      $("#loginModal").modal("show");

      setTimeout(() => {
        toast({
          title: "Thêm sản phẩm thất bại",
          message: "Bạn chưa đăng nhập.",
          type: "warning",
          duration: 1500,
        });
      }, 500);
    }
  });
});
// handle form add product to shopping cart

// choose option in  select category
document
  .getElementById("agileinfo-nav_search")
  .addEventListener("change", function (e) {
    let selectedOption = this.value;
    let currentUrl = window.location.href;

    if (currentUrl.indexOf("?") !== -1) {
      currentUrl = currentUrl.split("?")[0];
    }
    let hrefPage = `${currentUrl}?manager=ListCategory&id=${selectedOption}`;
    window.location.href = hrefPage;
  });
// select category

function calculateToTalAmount() {
  const sumToTal = Array.from(document.querySelectorAll(".total")).reduce(
    (acc, curr) => {
      curr = +curr.innerText.split(".").join("");
      return acc + curr;
    },
    0
  );

  document.querySelector(".totalMoney_number") &&
    (document.querySelector(".totalMoney_number").innerText =
      sumToTal.toLocaleString("vi-VN"));
}

calculateToTalAmount();

//
//
//
// handel form search
function handleformSearch() {
  document
    .getElementById("form_search")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      let formData = new FormData(this);
      const keysearch = formData.get("keySearch");
      const currentUrl = location.href.split("?")[0];
      const Url = `${currentUrl}?manager=search&key=${encodeURIComponent(
        keysearch
      )}`;

      $.ajax({
        type: "post",
        data: formData,
        url: Url,
        processData: false,
        contentType: false,
        success: function (response) {
          location.href = this.url;
        },
      });
    });
}
handleformSearch();

// --handel form search
const getNameUrl = window.location.href.split("=")[1];
const currentUrl = window.location.href;
if (getNameUrl === "viewOrder" || currentUrl.indexOf("viewOrder") !== -1) {
  document
    .querySelectorAll(".navbar_Order .nav-item")
    .forEach((element, index) => {
      element.addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelector(".content.active") &&
          document.querySelector(".content.active").classList.remove("active");

        document.querySelector(".navbar_Order .nav-item.active") &&
          document
            .querySelector(".navbar_Order .nav-item.active")
            .classList.remove("active");
        element.classList.add("active");

        const attriButeStatus = this.getAttribute("data-status");
        switch (attriButeStatus) {
          case "all":
            document.querySelectorAll(".rowElementView").forEach((row) => {
              !row.classList.contains("active") && row.classList.add("active");
            });
            break;
          case "pending":
            document.querySelectorAll(".rowElementView").forEach((row) => {
              !row.classList.contains("pending") &&
                row.classList.remove("active");
              row.classList.contains("pending") && row.classList.add("active");
            });
            break;
          case "delivering":
            document.querySelectorAll(".rowElementView").forEach((row) => {
              !row.classList.contains("delivering") &&
                row.classList.remove("active");
              row.classList.contains("delivering") &&
                row.classList.add("active");
            });
            break;
          case "complete":
            document.querySelectorAll(".rowElementView").forEach((row) => {
              !row.classList.contains("complete") &&
                row.classList.remove("active");
              row.classList.contains("complete") && row.classList.add("active");
            });
            break;
          case "cancel":
            document.querySelectorAll(".rowElementView").forEach((row) => {
              !row.classList.contains("cancel") &&
                row.classList.remove("active");
              row.classList.contains("cancel") && row.classList.add("active");
            });
            break;
        }
      });
    });
}

function showInfoRecipients() {
  document
    .querySelectorAll(".rowElementView.active")
    .forEach((element, index) => {
      element
        .querySelector("a.address-link")
        .addEventListener("click", function (event) {
          event.preventDefault();
          document
            .querySelectorAll(".content")
            [index].classList.toggle("active");
        });
    });
}

showInfoRecipients();

function cancelOrder() {
  document
    .querySelectorAll(".rowElementView.pending.active")
    .forEach((element, index) => {
      element
        .querySelector("a.cancle-link")
        .addEventListener("click", function (event) {
          event.preventDefault();

          if (confirm("Bạn có chắc chắn muốn huỷ đơn hàng?") == true) {
            const codeOrder = event.target.getAttribute("data-codeOrder");
            const idOrder = event.target.getAttribute("data-id");
            const formData = new FormData();
            formData.append("rqCancle", true);
            formData.append("codeOrder", codeOrder);
            formData.append("idOrder", idOrder);
            $.ajax({
              type: "post",
              data: formData,
              url: "./include/handleCancelOrder.php",
              processData: false,
              contentType: false,
              success: function (response) {
                setTimeout(() => {
                  if (getCookie("rqcc") == "true") {
                    location.reload();
                  }
                }, 2000);
              },
            });
          }
        });
    });
}
cancelOrder();

// for (const [key, value] of formData.entries()) {
//   console.log(key + ": " + value);
// }
