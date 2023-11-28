const NameWebsite = document.location.href.split("/").pop();
document.querySelector(".nav-item.active") &&
  document.querySelector(".nav-item.active").classList.remove("active");
switch (NameWebsite) {
  case "handleOrder.php":
    document.querySelectorAll(".nav-item")[0].classList.add("active");
    break;
  case "handleCategory.php":
    document.querySelectorAll(".nav-item")[1].classList.add("active");
    break;
  case "handleInfoCategories.php":
    document.querySelectorAll(".nav-item")[2].classList.add("active");
    break;
  case "handleProduct.php":
    document.querySelectorAll(".nav-item")[3].classList.add("active");
    break;
  case "handleCustomers.php":
    document.querySelectorAll(".nav-item")[4].classList.add("active");
    break;
  case "handleSlider.php":
    document.querySelectorAll(".nav-item")[5].classList.add("active");
    break;
}
