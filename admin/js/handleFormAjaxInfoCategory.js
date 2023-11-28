function showMessageError(message = "Chưa chọn loại danh mục") {
  document.querySelector(".messageError").classList.add("error");
  document.querySelector(".messageError").innerText = message;
}

function HideMessageError(message = "Chưa chọn loại danh mục") {
  document.querySelector(".messageError").innerText = message;
  document.querySelector(".messageError").classList.remove("error");
}

document.querySelector(".btnaddInputAttb") &&
  document
    .querySelector(".btnaddInputAttb")
    .addEventListener("click", (event) => {
      event.preventDefault();
    });

function handleDataAtrribute(listForm = "list-attb-Formadd") {
  const arrDataAttrbtElements = Array.from(
    document.getElementById(`${listForm}`).querySelectorAll(".list-group-item")
  );
  let stringDataAttb = arrDataAttrbtElements.reduce((prev, next) => {
    if (next.querySelector(".attrib-input").value) {
      return prev + next.querySelector(".attrib-input").value + "--";
    } else {
      return prev;
    }
  }, "--");

  stringDataAttb = stringDataAttb ? stringDataAttb.replace(/^--|--$/g, "") : "";

  let arrayAttributes = stringDataAttb && stringDataAttb.split("--");
  return arrayAttributes;
}

handleSelecChanged();

function handleSelecChanged() {
  document
    .getElementById("selecElementParent")
    .addEventListener("change", (event) => {
      if (event.target.value > 0) {
        document.querySelector(".messageError").classList.remove("error");
        let TagSelect = document.getElementById("selecElementParent");

        let IndexElementExists = Array.from(
          document.querySelectorAll(".elementNameValue")
        ).findIndex((element) => {
          return (
            element.innerText == TagSelect.options[TagSelect.selectedIndex].text
          );
        });

        if (IndexElementExists >= 0) {
          let checkValueElementExists = document
            .querySelectorAll(".rowElement")
            [IndexElementExists].querySelector(".list_infoCtg").innerText;

          if (!checkValueElementExists || checkValueElementExists) {
            document.querySelector(".containerForm").innerHTML = "";
            showMessageError(
              "Danh mục này đã có trong danh sách thông tin danh mục, bấm cập nhật để cập nhập lại"
            );
          }
        } else {
          runfromAdd(
            event.target.value,
            TagSelect.options[TagSelect.selectedIndex].text
          );
        }
      } else {
        document.querySelector(".containerForm").innerHTML = "";
        showMessageError();
      }
    });
}

function runfromAdd(IdCategory, valueNameCategory) {
  changeBodyFormLeft("add", IdCategory);

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

  // submit form add
  document
    .getElementById("formAdd")
    .addEventListener("submit", function (event) {
      let arrayAttributes = handleDataAtrribute();
      let stringDataAttb = "";
      if (arrayAttributes) {
        stringDataAttb =
          arrayAttributes.length > 1
            ? arrayAttributes.join("--")
            : arrayAttributes.join("");
      }
      event.preventDefault();

      let formData = new FormData();
      formData.append("btnAddNew", true);
      formData.append("arrdata", stringDataAttb);

      $.ajax({
        type: "post",
        data: formData,
        url: "handleInfoCategories.php",
        processData: false,
        contentType: false,
        success: function (response) {
          // add info category new
          let lastChildrowElement = document.querySelector(
            ".rowElement:last-child"
          );

          let html = "";
          html =
            arrayAttributes &&
            arrayAttributes
              .map((element, index) => {
                return `<li class="list-group-item"><span class="mr-1"> ${
                  index + 1
                }</span>: ${element}</li>`;
              })
              .join("");

          if (lastChildrowElement) {
            const cloneElement = lastChildrowElement.cloneNode(true);
            let idnew =
              +lastChildrowElement.querySelector(".orderElement").innerText + 1;

            cloneElement.querySelector(".orderElement").innerText = idnew;
            cloneElement.querySelector(".elementNameValue").innerText =
              valueNameCategory;
            cloneElement
              .querySelector(".formChangeEachElement")
              .querySelector(".idElementUpdate").value = IdCategory;
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
                                    <input type="hidden" name="idElement" class="idElementUpdate" value="1">
                                    <input type="hidden" name="statusBtn" value="" class="statusBtn">
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

          document.getElementById("selecElementParent").selectedIndex = 0;
          changeBodyFormLeft();
          runformChangeEachElement();
        },
      });
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
          url: "handleInfoCategories.php",

          success: function (response) {
            if (check) {
              const arrDataAttrbtElements = Array.from(
                document
                  .querySelectorAll(".rowElement")
                  [index].querySelector(".list_infoCtg")
                  .querySelectorAll(".list-group-item")
              );
              let stringDataAttb = arrDataAttrbtElements.reduce(
                (prev, next) => {
                  let ValueCurrentElement = next.innerText
                    .trim()
                    .split(":")[1]
                    .trim();
                  if (ValueCurrentElement) {
                    return prev + ValueCurrentElement + "--";
                  }
                },
                "--"
              );

              stringDataAttb = stringDataAttb.replace(/^--|--$/g, "");
              let arrayAttributes = stringDataAttb.split("--");

              changeBodyFormLeft(
                element.querySelector(".statusBtn").value,
                element.querySelector(".idElementUpdate").value,
                arrayAttributes
              );

              window.scrollTo(0, 0);

              runformUpdate(index);
            } else {
              runformDelete(element);
            }
          },
        });
        event.preventDefault();
      });
    });
}

function changeBodyFormLeft(statusBtn = "", id = -1, arrdata = "") {
  // console.log(statusBtn + " " + inputValue + " " + index);
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
                  <input type="submit" class="btn btn-primary" id="btnUpdate" name="btnUpdate" value="Cập nhập thông tin" />
              </div>
          </form>
    `;
  } else if (statusBtn != "update" && statusBtn == "add") {
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

  if (statusBtn == "update") {
    document
      .querySelector(".content_firstLeft")
      .querySelector(".titleContentForm").innerText = "Cập nhập thông tin";
    document
      .querySelector(".content_firstLeft")
      .querySelector(".form-select-wrap")
      .classList.remove("active");
  } else {
    document
      .querySelector(".content_firstLeft")
      .querySelector(".titleContentForm").innerText = "Thêm thông tin danh mục";

    document
      .querySelector(".content_firstLeft")
      .querySelector(".form-select-wrap")
      .classList.add("active");
  }
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
      event.preventDefault();

      let arrayAttributes = handleDataAtrribute("list-attb-FormUpd");
      let html = "";
      html =
        arrayAttributes &&
        arrayAttributes
          .map((element, index) => {
            return `<li class="list-group-item"><span class="mr-1"> ${
              index + 1
            }</span>: ${element}</li>`;
          })
          .join("");

      let stringDataAttb = "";
      if (arrayAttributes) {
        stringDataAttb =
          arrayAttributes.length > 1
            ? arrayAttributes.join("--")
            : arrayAttributes.join("");
      }

      let formData = new FormData();
      formData.append("btnUpdate", true);
      formData.append("arrdata", stringDataAttb);

      $.ajax({
        type: "post",
        data: formData,
        url: "handleInfoCategories.php",
        processData: false,
        contentType: false,
        success: function (response) {
          // update name catregory in html

          document
            .querySelectorAll(".rowElement")
            [index].querySelector(".list_infoCtg").innerHTML = html;

          document.getElementById("selecElementParent").selectedIndex = 0;
          HideMessageError();
          changeBodyFormLeft();
        },
      });
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
  changeBodyFormLeft();
}

document.querySelectorAll(".rowElement").forEach((element, index) => {
  element.querySelector(".orderElement").innerText = index + 1;
});
