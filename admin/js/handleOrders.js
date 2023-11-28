let formManager = document.querySelectorAll(".formChangeEachElement");
function handleFormShowDetails() {
  formManager.forEach((element, index) => {
    var request = new XMLHttpRequest();

    element.addEventListener("submit", (event) => {
      event.preventDefault();
      let check = false;
      let fileHandle = "handleOrder.php";

      let IdOrder = event.target.querySelector(".idElement").value;
      let formData = new FormData();
      formData.append("IdOrder", IdOrder);
      if (
        event.submitter.getAttribute("data-inputname") === "Btn_show_detail"
      ) {
        check = true;
        fileHandle = "modalDetailOrder.php";
      } else {
        formData.append("btnDelete", "true");
      }

      $.ajax({
        type: "post",
        data: formData,
        url: fileHandle,
        processData: false,
        contentType: false,
        success: function (response) {
          if (check) {
            $(".modal-content").html(response);
            $("#modal-detail").modal("show");
            let IDOrder = element.querySelector(
              'input[name="idElement"]'
            ).value;

            handleFormUpdate(
              IDOrder,
              document
                .querySelectorAll(".rowElement")
                [index].querySelector(".status")
            );
          } else {
            let pos = Array.from(
              document.querySelectorAll(".formChangeEachElement")
            ).indexOf(element);
            document.querySelectorAll(".rowElement")[pos].remove();
            document.querySelectorAll(".rowElement").forEach((element, i) => {
              element.querySelector(".orderElement").innerText = i + 1;
            });
          }
        },
      });

      request.upload.addEventListener("load", function () {}, false);
    });
  });
}

handleFormShowDetails();

function handleFormUpdate(IDOrder, elementStatus) {
  const arrayStatus = {
    0: "Chưa xử lý",
    1: "Đã xử lý",
    2: "Đã hoàn thành",
    4: "Đã huỷ",
  };

  const form = $("#formUpdateOrder");
  form.submit(function (e) {
    e.preventDefault();
    let radioValue = $('input[name="inputRadio"]:checked').val();
    let formData = new FormData();
    formData.append("valRadioInput", radioValue);
    formData.append("IdOrder", IDOrder);
    $.ajax({
      type: "post",
      data: formData,
      url: "handleOrder.php",
      processData: false,
      contentType: false,
      success: function (response) {
        $("#modal-detail").modal("hide");
        elementStatus.innerText = arrayStatus[radioValue];
      },
    });
  });
}
