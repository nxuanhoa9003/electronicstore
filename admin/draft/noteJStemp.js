runformChangeEachElement();

function runformChangeEachElement() {
  document
    .querySelectorAll(".formChangeEachElement")
    .forEach(function (element, index) {
      element.addEventListener("submit", function (event) {
        let check = false;
        //  check button
        if (event.submitter.getAttribute("data-inputName") == "update") {
          element.querySelector(".statusBtn").value = "update";
          check = !check;
        } else {
          element.querySelector(".statusBtn").value = "delete";
        }

        $.ajax({
          type: "post",
          data: $(this).serialize() + (check ? "" : "&btnDelete=true"),
          url: "handleInfoCategories.php",

          success: function (response) {
            const arrDataAttrbtElements = Array.from(
              document
                .querySelectorAll(".rowElement")
                [index].querySelector(".list_infoCtg")
                .querySelectorAll(".list-group-item")
            );
            let stringDataAttb = arrDataAttrbtElements.reduce((prev, next) => {
              let ValueCurrentElement = next.innerText
                .trim()
                .split(":")[1]
                .trim();
              if (ValueCurrentElement) {
                return prev + ValueCurrentElement + "--";
              }
            }, "--");

            stringDataAttb = stringDataAttb.replace(/^--|--$/g, "");
            let arrayAttributes = stringDataAttb.split("--");

            changeBodyFormLeft(
              arrayAttributes,
              element.querySelector(".statusBtn").value,
              element.querySelector(".ElementNameUpdate").value,
              element.querySelector(".idElementUpdate").value
            );

            if (check) {
              runformUpdate(index);
            } else {
              runformDelete(element);
              // console.log(this.data);
            }
          },
        });
        event.preventDefault();
      });
    });
}

function changeBodyFormLeft(
  arrdata = "",
  statusBtn = "",
  inputValue = "",
  id = -1
) {
  let html = "";
  if (statusBtn == "update") {
    let tempHtml = "";
    if (arrdata.length > 0) {
      tempHtml = arrdata
        .map((element, index) => {
          return `<li class="list-group-item p-0">
                    <input type="text" class="form-control attrib-input" name="attrib-${
                      index + 1
                    }" value="${element}" placeholder="Nhập tiêu đề thông tin">
                  </li>`;
        })
        .join("");
    } else {
      tempHtml = `
                <li class="list-group-item p-0">
                    <input type="text" class="form-control attrib-input" name="attrib-1" value="" placeholder="Nhập tiêu đề thông tin">
                </li>
        `;
    }

    html = `
          <form id="formUpdate">
              <div class="form-group">
                  <ul class="list-group text-left" id="list-attb-FormUpd">
                      ${tempHtml}
                  </ul>
                  <div class="d-flex justify-content-end">
                    <div class="btn btnaddInputAttb mt-2 mr-2" title="Thêm ô nhập">
                      <span>+</span>
                    </div>
                  </div>
              </div>
              <div class="form-group text-left ">
                  <input type="hidden"  name="IdCategory" value="${id}" />
                  <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Cập nhập thông tin" />
              </div>
          </form>
    `;
  }
  document.querySelector(".containerForm").innerHTML = "";
  document.querySelector(".containerForm").innerHTML = html;
}

function runformUpdate(index) {
  const bntAddAttb = document.querySelector(".btnaddInputAttb");
  bntAddAttb.addEventListener("click", (event) => {
    let numberLi = document
      .getElementById("list-attb-FormUpd")
      .querySelectorAll("li.list-group-item");
    let li = document.createElement("li");
    li.classList.add("list-group-item", "p-0");
    li.innerHTML = `
                    <input type="text" class="form-control attrib-input" name="attr-${
                      numberLi.length + 1
                    }" value="" placeholder="Nhập tiêu đề thông tin">
                   `;
    document.getElementById("list-attb-FormUpd").appendChild(li);
  });

  document
    .getElementById("formUpdate")
    .addEventListener("submit", function (event) {
      const arrDataAttrbtElements = Array.from(
        document
          .getElementById("list-attb-FormUpd")
          .querySelectorAll(".list-group-item")
      );
      let stringDataAttb = arrDataAttrbtElements.reduce((prev, next) => {
        if (next.querySelector(".attrib-input").value) {
          return prev + next.querySelector(".attrib-input").value + "--";
        }
      }, "--");

      stringDataAttb = stringDataAttb.replace(/^--|--$/g, "");
      let arrayAttributes = stringDataAttb.split("--");

      let html = "";
      html = arrayAttributes
        .map((element, index) => {
          return `<li class="list-group-item"><span class="mr-1"> ${
            index + 1
          }</span>: ${element}</li>`;
        })
        .join("");

      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnUpdate=true`,
        url: "handleInfoCategories.php",

        success: function (response) {
          changeBodyFormLeft();
          console.log(this.data);

          document
            .querySelectorAll(".rowElement")
            [index].querySelector(".list_infoCtg").innerHTML = html;

          runformChangeEachElement();
        },
      });
      event.preventDefault();
    });
}

function runformDelete(element) {
  let index = Array.from(
    document.querySelectorAll(".formChangeEachElement")
  ).indexOf(element);
  document.querySelectorAll(".rowElement")[index].remove();
  document.querySelectorAll(".rowElement").forEach((element, index) => {
    element.querySelector(".orderElement").innerText = index + 1;
  });
}

document.querySelectorAll(".rowElement").forEach((element, index) => {
  element.querySelector(".orderElement").innerText = index + 1;
});
