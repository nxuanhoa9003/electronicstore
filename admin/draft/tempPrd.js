function changeTextMessageError(message = "Chưa chọn loại danh mục") {
  document.querySelector(".messageError").classList.add("error");
  document.querySelector(".messageError").innerText = message;
}

document.querySelector(".btnaddInputAttb") &&
  document
    .querySelector(".btnaddInputAttb")
    .addEventListener("click", (event) => {
      event.preventDefault();
    });

document.getElementById("selecCategory").addEventListener("change", (event) => {
  if (event.target.value > 0) {
    document.querySelector(".messageError").classList.remove("error");
    let TagSelect = document.getElementById("selecCategory");

    let IndexElementExists = Array.from(
      document.querySelectorAll(".elementNameValue")
    ).findIndex((element) => {
      return (
        element.innerText == TagSelect.options[TagSelect.selectedIndex].text
      );
    });

    let checkValueElementExists = document
      .querySelectorAll(".rowElement")
      [IndexElementExists].querySelector(".list_infoCtg").innerText;

    if (!checkValueElementExists) {
      runfromAdd(
        event.target.value,
        TagSelect.options[TagSelect.selectedIndex].text
      );
    } else {
      document.querySelector(".containerForm").innerHTML = "";
      changeTextMessageError("Danh mục này đã có thông tin, hãy cập nhật lại");
    }
  } else {
    document.querySelector(".containerForm").innerHTML = "";
    changeTextMessageError();
  }
});

function runfromAdd(IdCategory, valueNameCategory) {
  changeBodyFormLeft("", "", IdCategory);

  const bntAddAttb = document.querySelector(".btnaddInputAttb");
  bntAddAttb.addEventListener("click", (event) => {
    let numberLi = document
      .getElementById("list-attb-Formadd")
      .querySelectorAll("li.list-group-item");
    let li = document.createElement("li");
    li.classList.add("list-group-item", "p-0");
    li.innerHTML = `
                    <input type="text" class="form-control attrib-input" name="attr-${
                      numberLi.length + 1
                    }" value="" placeholder="Nhập tiêu đề thông tin">
                   `;
    document.getElementById("list-attb-Formadd").appendChild(li);
  });

  document
    .getElementById("formAdd")
    .addEventListener("submit", function (event) {
      const arrDataAttrbtElements = Array.from(
        document
          .getElementById("list-attb-Formadd")
          .querySelectorAll(".list-group-item")
      );
      let stringDataAttb = arrDataAttrbtElements.reduce((prev, next) => {
        if (next.querySelector(".attrib-input").value) {
          return prev + next.querySelector(".attrib-input").value + "--";
        }
      }, "--");

      stringDataAttb = stringDataAttb.replace(/^--|--$/g, "");
      let arrayAttributes = stringDataAttb.split("--");

      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnAddNew=true&arrdata=${stringDataAttb}`,
        // url: "handleInfoCategories.php",
        success: function (response) {
          // add info category new
          console.log(this.data);
          if (stringDataAttb) {
            let lastChildrowElement = document.querySelector(
              ".rowElement:last-child"
            );

            let html = "";
            html = arrayAttributes
              .map((element, index) => {
                return `<li class="list-group-item"><span class="mr-1"> ${
                  index + 1
                }</span>: ${element}</li>`;
              })
              .join("");

            if (lastChildrowElement) {
              const cloneElement = lastChildrowElement.cloneNode(true);
              let idnew =
                +lastChildrowElement.querySelector(".orderElement").innerText +
                1;

              cloneElement.querySelector(".orderElement").innerText = idnew;
              cloneElement.querySelector(".elementNameValue").innerText =
                valueNameCategory;
              cloneElement.querySelector(".list_infoCtg").innerText = "";
              cloneElement.querySelector(".list_infoCtg").innerHTML = html;
              lastChildrowElement.parentNode.appendChild(cloneElement);
            } else {
              let tempHtml = `
                <tr class="rowElement">
                    <th class="align-middle orderElement" scope="row">1</th>
                    <td class="align-middle" colspan="2">
                        <div class="text-left elementNameValue">
                            ${valueNameCategory}
                        </div>
                    </td>
                    <td class="align-middle" colspan="2">
                        <ul class="list-group list_infoCtg text-left">
                        </ul>

                    </td>
                    <td class="align-middle">
                        <form class="formChangeEachElement">
                            <div class="row d-grid m-0">
                                <div class="col-12">
                                    <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                    <input type="hidden" name="idElement" class="idElementUpdate" value="">
                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                    <input type="hidden" name="tableName" class="tableNameforElement" value="">
                                    <input type="hidden" name="elementName" class="ElementNameUpdate" value="">
                                </div>
                                <div class="col m-2"></div>
                                <div class="col-12">
                                    <input type="submit" data-inputName="delete" name="btnDelete" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
              `;

              document.querySelector(".TableBodyListElements").innerHTML =
                tempHtml;
              document
                .querySelector(".rowElement")
                .querySelector(".list_infoCtg").innerHTML = html;
            }

            runformChangeEachElement();
          }
        },
      });
      event.preventDefault();
    });
}

runformChangeEachElement();

function runformChangeEachElement() {
  document
    .querySelectorAll(".formChangeEachElement")
    .forEach(function (element, index) {
      element.addEventListener("submit", function (event) {
        let check = false;
        if (event.submitter.getAttribute("data-inputName") == "update") {
          element.querySelector(".statusBtn").value = "update";
          check = !check;
        } else {
          element.querySelector(".statusBtn").value = "delete";
        }

        $.ajax({
          type: "post",
          data: $(this).serialize() + (check ? "" : "&btnDelete=true"),
          // url: "handleInfoCategories.php",

          success: function (response) {
            changeBodyFormLeft(
              element.querySelector(".statusBtn").value,
              element.querySelector(".ElementNameUpdate").value,
              element.querySelector(".idElementUpdate").value
            );

            if (check) {
              runformUpdate(index);
            } else {
              runformDelete(element);
              console.log(this.data);
            }
          },
        });
        event.preventDefault();
      });
    });
}

function changeBodyFormLeft(statusBtn = "", inputValue = "", id = -1) {
  // console.log(statusBtn + " " + inputValue + " " + index);
  let html = "";
  if (statusBtn == "update") {
    html = `
          <div class="p-1">
          <h4>Cập nhật danh mục</h4>
          </div>
  
          <form id="formUpdate" action="">
              <div class="form-group">
                  <input type="text" class="form-control" id="InputValueNameElement" name="InputValueNameElement" value="${inputValue}" placeholder="Nhập tên danh mục...">
                  <input type="hidden" name="inputIdElementUpdate" value="" class="inputIdElementUpdate">
                  </div>
              <div class="form-group text-left ">
                  <input type="submit" class="btn btn-primary" id="btnUpdate" name="btnUpdate" value="Cập nhập" />
              </div>
          </form>
          `;
  } else {
    html = `
          <form id="formAdd">
              <div class="form-group">
                  <ul class="list-group text-left" id="list-attb-Formadd">
                      <li class="list-group-item p-0">
                        <input type="text" class="form-control attrib-input" name="attrib-1" value="" placeholder="Nhập tiêu đề thông tin">
                      </li>
                  </ul>
                  <div class="d-flex justify-content-end">
                    <div class="btn btnaddInputAttb mt-2 mr-2" title="Thêm ô nhập">
                      <span>+</span>
                    </div>
                  </div>
              </div>
              <div class="form-group text-left ">
                  <input type="hidden"  name="IdCategory" value="${id}" />
                  <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Lưu thông tin" />
              </div>
          </form>
    `;
  }
  document.querySelector(".containerForm").innerHTML = "";
  document.querySelector(".containerForm").innerHTML = html;
}

function runformUpdate(index) {
  document
    .getElementById("formUpdate")
    .addEventListener("submit", function (event) {
      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnUpdate=true`,
        // url: "handleInfoCategories.php",

        success: function (response) {
          // update name catregory in html

          changeBodyFormLeft();
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
