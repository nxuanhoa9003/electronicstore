document
  .getElementById("formSelectPoster")
  .addEventListener("submit", function (event) {
    event.preventDefault();
    let e = document.getElementById("selectPoster");
    if (e.value) {
      let value = e.value;
      let text = e.options[e.selectedIndex].text;
      const formData = new FormData();
      formData.append("selectPoster", true);
      formData.append("selectPosterValue", value);
      formData.append("selectPosterText", text);
      $.ajax({
        type: "post",
        data: formData,
        url: "showSlider.php",
        processData: false,
        contentType: false,
        success: function (response) {
          $(".carousel_wrap").html(response);
          e.value == 0 && $(".containerForm").html("");
          e.value > 0 && handleFormChangePoster(e.value);
        },
      });
    }
  });

function handleFormChangePoster(SliderIndex) {
  document
    .getElementById("formchange")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      if (event.submitter.name === "update") {
        $.ajax({
          type: "post",
          data: `update=true&btn=update&sliderID=${SliderIndex}`,
          url: "formSlider.php",
          success: function (response) {
            $(".containerForm").html(response);
            handleFormSavePoster((btn = "update"), SliderIndex);
          },
        });
      } else if (event.submitter.name === "delete") {
        $.ajax({
          type: "post",
          data: `delete=true&btn=delete&sliderId=${SliderIndex}`,
          url: "handleSlider.php",
          success: function (response) {
            location.reload();
          },
        });
      } else if (event.submitter.name === "isactive") {
        const dataName = event.submitter.getAttribute("data-name");
        const isactive = dataName === "show" ? 1 : 0;
        $.ajax({
          type: "post",
          data: `active=true&btn=active&sliderId=${SliderIndex}&isactive=${isactive}`,
          url: "handleSlider.php",
          success: function (response) {
            location.reload();
          },
        });
      }
    });
}

function validateForm() {
  document
    .querySelectorAll("input[type=text]")
    .forEach(function (element, index) {
      if (!element.value) {
        return false;
      }
    });
  if (document.querySelector("input[type=file]").files.length === 0) {
    return false;
  }
  if (!document.getElementById("select-Category").value) {
    return false;
  }
  return true;
}

function handleFormSavePoster(btn = "add", SliderIndex = "") {
  const formSave = document.getElementById("formSave");
  formSave
    .querySelector("#attrib-2")
    .addEventListener("blur", function (event) {
      if (event.target.value) {
        const ValueInput = event.target.value.split(" ");

        let html = ValueInput.map((element, index) => {
          return `<input type="checkbox" id="text${index + 1}" name="text${
            index + 1
          }" value="${element}">
          <label for="text${index + 1}">${element}</label><br>`;
        }).join("");

        formSave.querySelector(".SelectTextHighLight").innerHTML = html;
      }
    });

  formSave.addEventListener("submit", function (event) {
    event.preventDefault();
    if (validateForm()) {
      const formData = new FormData(this);
      const text = document.getElementById("select-Category").value;
      formData.append("selectCategory", text);
      if (
        formSave.querySelectorAll('input[type="checkbox"]:checked').length > 0
      ) {
        let textNew = "";
        const titlePrimary = formData.get("attrib-2");
        formSave
          .querySelectorAll('input[type="checkbox"]:checked')
          .forEach((element, index) => {
            const Value = element.value;
            textNew = titlePrimary.replace(
              new RegExp(`${Value}`, "g"),
              `<span>${Value}</span>`
            );
          });
        formData.append("strHightLight", textNew);
        formData.append("SliderIndex", SliderIndex);
        formData.append("issave", true);
        btn === "add" && formData.append("add", true);
        btn === "update" && formData.append("update", true);
      }
      $.ajax({
        type: "post",
        data: formData,
        url: "handleSlider.php",
        processData: false,
        contentType: false,
        success: function (response) {},
      });

      for (const [key, value] of formData.entries()) {
        console.log(key + ": " + value);
      }
    }
  });
}

document.getElementById("btnAdd").addEventListener("click", function (event) {
  event.preventDefault();
  $.ajax({
    type: "post",
    data: "add=true&btn=add",
    url: "formSlider.php",
    success: function (response) {
      $(".carousel_wrap").html("");
      $(".containerForm").html(response);
      handleFormSavePoster((btn = "add"));
    },
  });
});
