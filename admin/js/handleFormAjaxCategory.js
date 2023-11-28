function showMessageError(message = "Đã có danh mục này") {
  document.querySelector(".messageError").classList.add("error");
  document.querySelector(".messageError").innerText = message;
}

function HideMessageError(message = "") {
  document.querySelector(".messageError").innerText = message;
  document.querySelector(".messageError").classList.remove("error");
}

runformAdd();
function runformAdd() {
  document
    .getElementById("formAdd")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const inputNewNameCTGR = document.getElementById(
        "InputValueNameElement"
      ).value;

      let checkAdd = Array.from(document.querySelectorAll(".rowElement")).every(
        (element) =>
          element.querySelector(".elementNameValue").innerText.toLowerCase() !==
          inputNewNameCTGR.trim().toLowerCase()
      );

      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnAddNew=${checkAdd ? "true" : "false"}`,
        url: "handleCategory.php",
        success: function (response) {
          // add category new to list of categories

          if (checkAdd) {
            if (inputNewNameCTGR) {
              let lastChildrowElement = document.querySelector(
                ".rowElement:last-child"
              );

              if (lastChildrowElement) {
                const cloneElement = lastChildrowElement.cloneNode(true);
                let idnew =
                  +lastChildrowElement.querySelector(".orderElement")
                    .innerText + 1;
                cloneElement.querySelector(".orderElement").innerText = idnew;

                cloneElement.querySelector(".elementNameValue").innerText =
                  inputNewNameCTGR;
                cloneElement
                  .querySelector(".formChangeEachElement")
                  .querySelector(".idElementUpdate").value = idnew;

                cloneElement
                  .querySelector(".formChangeEachElement")
                  .querySelector(".ElementNameUpdate").value = inputNewNameCTGR;

                lastChildrowElement.parentNode.appendChild(cloneElement);
              } else {
                let html = `<tr class="rowElement">
                          <th class="align-middle orderElement" scope="row">1</th>
                          <td class="align-middle" colspan="2">
                              <div class="text-left elementNameValue">
                                  ${inputNewNameCTGR}
                              </div>
                          </td>
                          <td class="align-middle">
                              <form class="formChangeEachElement">
                                  <div class="row d-grid m-0">
                                      <div class="col-md-6">
                                          <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                          <input type="hidden" name="idElement" class="idElementUpdate" value="1">
                                          <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                          <input type="hidden" name="elementName" class="ElementNameUpdate" value="${inputNewNameCTGR}">
                                      </div>
                                      <div class="col m-2 m-md-0 d-md-none"></div>
                                      <div class="col-md-6">
                                          <input type="submit" data-inputName="delete" name="btnDelete" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                                      </div>
                                  </div>
                              </form>
                          </td>
                        </tr>`;

                document.querySelector(".TableBodyListElements").innerHTML =
                  html;

                document
                  .querySelectorAll(".rowElement")
                  .forEach((element, index) => {
                    element.querySelector(".orderElement").innerText =
                      index + 1;
                  });
              }

              runformChangeEachElement();

              document.getElementById("formAdd").reset();
            } else {
              showMessageError("Chưa nhập tên danh mục");
            }
          } else {
            showMessageError();
          }
        },
      });

      // event.preventDefault();
    });
}

document
  .getElementById("InputValueNameElement")
  .addEventListener("input", (event) => {
    HideMessageError();
  });

runformChangeEachElement();

function runformChangeEachElement() {
  document
    .querySelectorAll(".formChangeEachElement")
    .forEach(function (element, index) {
      element.addEventListener("submit", function (event) {
        event.preventDefault();

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
          url: "handleCategory.php",

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
              // console.log(this.data);
            }
          },
        });
        // event.preventDefault();
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
        <div class="p-1">
            <h4>Thêm danh mục</h4>
        </div>

        <form id="formAdd" action="">
            <div class="form-group">
              <input type="text" class="form-control" id="InputValueNameElement" name="InputValueNameElement" value="" placeholder="Nhập tên danh mục...">
              </div>
            <div class="form-group text-left ">
              <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Thêm danh mục" />
            </div>
        </form>
        `;
  }
  document.querySelector(".content_firstLeft").innerHTML = html;
  document.getElementById("formUpdate") &&
    (document
      .getElementById("formUpdate")
      .querySelector(".inputIdElementUpdate").value = id);
}

function runformUpdate(index) {
  document
    .getElementById("formUpdate")
    .addEventListener("submit", function (event) {
      const inputNewNameCTGRUpd = document.getElementById(
        "InputValueNameElement"
      ).value;

      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnUpdate=true`,
        url: "handleCategory.php",

        success: function (response) {
          // update name catregory in html

          document
            .querySelectorAll(".rowElement")
            [index].querySelector(".elementNameValue").innerText =
            inputNewNameCTGRUpd;
          document
            .querySelectorAll(".formChangeEachElement")
            [index].querySelector(".ElementNameUpdate").value =
            inputNewNameCTGRUpd;

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
  runformAdd();
}

document.querySelectorAll(".rowElement").forEach((element, index) => {
  element.querySelector(".orderElement").innerText = index + 1;
});

// Converting standard Vietnamese Characters to non-accent ones
function toLowerCaseNonAccentVietnamese(str) {
  str = str.toLowerCase();
  str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
  str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
  str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
  str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
  str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
  str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
  str = str.replace(/đ/g, "d");
  // Some system encode vietnamese combining accent as individual utf-8 characters
  str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, ""); // Huyền sắc hỏi ngã nặng
  str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
  str = str.replace(/\s/g, "");
  return str;
}
// Converting standard Vietnamese Characters to non-accent ones
