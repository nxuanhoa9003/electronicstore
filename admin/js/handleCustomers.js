let formManager = document.querySelectorAll(".formChangeEachElement");
function handleFormShowDetails() {
  formManager.forEach((element, index) => {
    var request = new XMLHttpRequest();

    element.addEventListener("submit", (event) => {
      event.preventDefault();

      let transactionCode = event.target.querySelector(".idElement").value;
      let formData = new FormData();
      formData.append("transactionCode", transactionCode);

      $.ajax({
        type: "post",
        data: formData,
        url: "modalTransactionCustomers.php",
        processData: false,
        contentType: false,
        success: function (response) {
          $(".modal-content").html(response);
          $("#modal-detail").modal("show");
        },
      });

      request.upload.addEventListener("load", function () {}, false);
    });
  });
}

handleFormShowDetails();
