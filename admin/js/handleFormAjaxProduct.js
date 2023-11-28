function showMessageError(message = "Chưa chọn loại danh mục") {
  handleChangeInputFile;
  document.querySelector(".messageError").classList.add("error");
  document.querySelector(".messageError").innerText = message;
}

function HideMessageError(message = "Chưa chọn loại danh mục") {
  document.querySelector(".messageError").innerText = message;
  document.querySelector(".messageError").classList.remove("error");
}

document
  .getElementById("selecElementParent")
  .addEventListener("change", (e) => {
    document.querySelector(".containerForm").innerHTML = "";
    document
      .querySelector(".content_firstLeft")
      .querySelector(".desc")
      .classList.remove("active");
    HideMessageError();
  });

function handleChangeInputFile() {
  document.querySelectorAll("input.imgElement").forEach((element, index) => {
    element.addEventListener("change", (e) => {
      element.parentNode
        .querySelector(".wrap_img-update")
        .classList.add("active");
      let file = e.target.files[0];
      let imagePreview = element.parentNode.querySelector(".img-right");
      const reader = new FileReader();
      reader.addEventListener(
        "load",
        () => {
          // convert image file to base64 string
          imagePreview.src = reader.result;
        },
        false
      );

      if (file) {
        reader.readAsDataURL(file);
      }
    });
  });
}

function validateform(
  nameform = "formAdd",
  selectorList = "list-attb-Formadd"
) {
  const form = document.getElementById(nameform);
  const ListItems = document
    .getElementById(selectorList)
    .querySelectorAll(".list-group-item .form-group");
  let formData = new FormData(form);
  const formDataArray = Array.from(formData.entries());
  let check = false;

  formDataArray.forEach((element, index) => {
    const [key, value] = formDataArray[index];

    if (form.elements[index].type === "file") {
      const file = form.elements[index].files[0];

      if (nameform === undefined) {
        if (!file) {
          check = true;
          ListItems[index]
            .querySelector(".messageError")
            .classList.add("error");
        } else {
          ListItems[index]
            .querySelector(".messageError")
            .classList.remove("error");
        }
      }
    } else if (form.elements[index].type === "text") {
      if (!value) {
        check = true;
        ListItems[index].querySelector(".messageError").classList.add("error");
      } else {
        ListItems[index]
          .querySelector(".messageError")
          .classList.remove("error");
      }
    }
  });

  return {
    checkEmtpy: check,
    form: formData,
  };
}

handleSelecChanged();

function handleSelecChanged() {
  document
    .getElementById("selecElementParent")
    .addEventListener("change", function (event) {
      document.getElementById("form-select").querySelector(".idselect").value =
        event.target.value;
    });

  document
    .getElementById("form-select")
    .addEventListener("submit", function (e) {
      let TagSelect = document.getElementById("selecElementParent");
      let IDSelect = TagSelect.value;
      e.preventDefault();
      $.ajax({
        type: "post",
        data: $(this).serialize(),
        url: "handleProduct.php",
        success: function (response) {
          if (IDSelect > 0) {
            HideMessageError();
            // call function in file handleProduct.php
            let listInputInfoPrd = RenderDataProduct();
            // call function in file handleProduct.php
            //
            if (listInputInfoPrd) {
              document
                .querySelector(".content_firstLeft")
                .querySelector(".desc")
                .classList.add("active");
              runfromAdd(
                IDSelect,
                TagSelect.options[TagSelect.selectedIndex].text,
                listInputInfoPrd
              );
            } else {
              document
                .querySelector(".content_firstLeft")
                .querySelector(".desc")
                .classList.remove("active");
              showMessageError("Sản phẩm chưa có tiêu đề thông tin");
              document.querySelector(".containerForm").innerHTML = "";
            }
          } else {
            showMessageError();
            document
              .querySelector(".content_firstLeft")
              .querySelector(".desc")
              .classList.remove("active");
            document.querySelector(".containerForm").innerHTML = "";
          }
        },
      });
    });
}

function runfromAdd(IdCategory, valueNameCategory, strData) {
  changeBodyFormLeft("add", IdCategory, strData);
  var request = new XMLHttpRequest();

  document
    .getElementById("formAdd")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const objValidateform = validateform();

      if (!objValidateform.checkEmtpy) {
        objValidateform.form.append("statusBtn", "add");
        objValidateform.form.append("btnAddNew", "true");

        let priceProduct = Number(
          objValidateform.form.get("attrib-2")
        ).toLocaleString("vi-VN");

        let srcImgProduct = objValidateform.form.get("image-1").name;
        $.ajax({
          type: "post",
          data: objValidateform.form,
          url: "handleProduct.php",
          processData: false,
          contentType: false,
          success: function (response) {
            // add info category new
            let lastChildrowElement = document.querySelector(
              ".rowElement:last-child"
            );
            if (lastChildrowElement) {
              const cloneElement = lastChildrowElement.cloneNode(true);

              let idnew =
                +lastChildrowElement.querySelector(".orderElement").innerText +
                1;

              cloneElement.querySelector(".orderElement").innerText = idnew;
              cloneElement.querySelector(".elementNameValue").innerText =
                valueNameCategory;

              cloneElement
                .querySelector(".formChangeEachElement")
                .querySelector(".idElementUpdate").value = IdCategory;
              cloneElement.querySelector(".Product_price").innerText =
                priceProduct;
              cloneElement.querySelector(".Product_img img").src =
                srcImgProduct;

              lastChildrowElement.parentNode.appendChild(cloneElement);
            } else {
              let tempHtml = `
              <tr class="rowElement">
                  <th class="align-middle orderElement" scope="row">1</th>
                  <td class="align-middle w-25" colspan="2">
                      <div class="text-left elementNameValue">
                        ${valueNameCategory}
                      </div>
                  </td>
                  <td class="w-25">
                      <div class="text-left TypeCategory">
                      </div>
                  </td>
                  <td class="w-25">
                    <div class="text-center Product_price">          
                      ${priceProduct}
                    </div>
                  </td>
                  <td class="w-25">
                    <div class="text-center Product_img">          
                      <image class="img-thumbnail" style="border-style: none" src="../uploads/${srcImgProduct}" alt="" />
                    </div>
                  </td>
                  <td class="align-middle w-50">
                      <form class="formChangeEachElement">
                          <div class="row row-cols-2 d-grid m-0">
                              <div class="col-md-6">
                                  <input type="submit" data-inputName="update" name="btnUpdate" value="Cập nhập" class="d-block w-100 text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                  <input type="hidden" name="idElement" class="idElementUpdate" value="">
                                  <input type="hidden" name="idTypeCategory" class="idTypeCategory" value="${IdCategory}">
                                  <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                  <input type="hidden" name="elementName" class="ElementNameUpdate" value="">
                              </div>
                              <div class="col-12 m-2 m-md-0 d-md-none"></div>
                              <div class="col-md-6">
                                  <input type="submit" data-inputName="delete" name="btnDelete" value="Xoá" class="d-block w-100 text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                              </div>
                          </div>
                      </form>
                  </td>
              </tr>
                `;
              document.querySelector(".TableBodyListElements").innerHTML =
                tempHtml;
            }
            document.getElementById("selecElementParent").selectedIndex = 0;
            // changeBodyFormLeft();
            runformChangeEachElement();
          },
        });

        request.upload.addEventListener(
          "load",
          function () {
            // console.log("loaded and complete");
          },
          false
        );
      }
    });
}

// render form input info prooduct
function getCookie(name) {
  const value = `; ${document.cookie}`;
  // delete cookie
  document.cookie = `${name}=; expires=H, 01 Jan 1970 00:00:00 UTC; path=/web_electro_store/admin;`;
  const parts = value.split(`; ${name}=`);

  if (parts.length === 2) {
    return decodeURIComponent(parts.pop().split(";").shift());
  }

  return null;
}

function RenderDataProduct(CookieName = "data") {
  let strData = getCookie(CookieName);

  let html = "";
  if (strData) {
    let arrData = strData.trim().split("--");

    if (arrData) {
      html = arrData
        .map((element, index) => {
          return `<li class="list-group-item p-0">
                  <div class="form-group">
                      <label class="pl-2" for="attrib-${
                        index + 1
                      }">${element}</label>
                      <input type="text" class="form-control attrib-input" id="attrib-${
                        index + 1
                      }" name="attrib-${index + 1}" value="" placeholder="">
                      <p class="px-3 text-left messageError">Chưa nhập thông tin</p>
                  </div>
                  
              </li>`;
        })
        .join("");

      for (let i = 1; i <= 3; i++) {
        html += `
              <li class="list-group-item p-0">
                  <div class="form-group">
                      <label class="pl-2" for="image-${i}">Tải ảnh sản phẩm ${i}</label>
                      <input type="file" title=" " class="form-control attrib-input" id="image-${i}" name="image-${i}" accept="image/*" />
                      <p class="px-3 text-left messageError">Chưa chọn ảnh</p>    
                  </div>  
              </li>  
              `;
      }
    }
  }

  return html;
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
          url: "handleProduct.php",

          success: function (response) {
            if (check) {
              let strTitileInput = getCookie("data1");
              let strData = getCookie("data2");
              let arrayAttributes = strTitileInput.split("--");
              let arrayInputValues = strData.split("|--|");
              console.log(arrayInputValues);

              let arrayBigGross = {
                title: arrayAttributes,
                data: arrayInputValues,
              };
              changeBodyFormLeft(
                element.querySelector(".statusBtn").value,
                {
                  parent: element.querySelector(".idTypeCategory").value,
                  child: element.querySelector(".idElementUpdate").value,
                },
                arrayBigGross
              );
              handleChangeInputFile();

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
    let arraTitle = arrdata["title"];
    let arraValueInput = arrdata["data"];

    let tempHtml = "";
    let pos = 0;
    if (arraValueInput.length > 0) {
      tempHtml = arraValueInput
        .map((element, index) => {
          if (arraValueInput.length - index > 3) {
            return `<li class="list-group-item p-0">
                  <div class="form-group">
                      <label class="pl-2" for="attrib-${index + 1}">${
              arraTitle[index]
            }</label>
                      <input type="text" class="form-control attrib-input" id="attrib-${
                        index + 1
                      }" name="attrib-${
              index + 1
            }" value="${element}" placeholder="">
                      <p class="px-3 text-left messageError">Chưa nhập thông tin</p>
                  </div>  
              </li>`;
          } else {
            pos++;
            return `
                  <li class="list-group-item p-0">
                    <div class="form-group">
                        <label class="pl-2" for="image-${pos}">Tải ảnh sản phẩm ${pos}</label>
                        <input type="file" title=""  class="imgElement form-control attrib-input" id="image-${pos}" name="image-${pos}" accept="image/*" />
                        <div class="form-group wrap_img-update">
                          <img class="img-left mt-1 img-thumbnail w-25" src="../uploads/${element}" alt="">
                          <div class="mx-3 arrow-icon"><i class="transform_arrow fa-solid fa-arrow-right"></i></div>
                          <img class="img-right mt-1 img-thumbnail w-25" src="" alt="">
                        </div>
                    </div>  
                  </li>  
                    `;
          }
        })
        .join("");
    }

    html = `
          <form id="formUpdate" method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <ul class="list-group text-left" id="list-attb-FormUpd">
                      ${tempHtml}
                  </ul>
                  
              </div>
              <div class="form-group text-left ">
                  <input type="hidden"  name="IdCategory" value="${id.parent}" />
                  <input type="hidden" name="idElementUpdate" class="idElementUpdate" value="${id.child}">
                  <input type="submit" class="btn btn-primary" id="btnUpdate" name="btnUpdate" value="Cập nhập thông tin" />
              </div>
          </form>
    `;
  } else if (statusBtn != "update" && statusBtn == "add") {
    // FORM ADD
    html = `
          <form id="formAdd" methos="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <ul class="list-group text-left" id="list-attb-Formadd">
                      ${arrdata}
                  </ul>
                  
              </div>
              <div class="form-group text-left ">
                  <input type="hidden"  name="IdCategory" value="${id}" />
                  <input type="submit" class="btn btn-primary" id="btnAddNew" name="btnAddNew" value="Thêm sản phấm" />
              </div>
          </form>
    `;
  }
  document.querySelector(".containerForm").innerHTML = "";
  document.querySelector(".containerForm").innerHTML = html;

  if (statusBtn == "update") {
    document
      .querySelector(".content_firstLeft")
      .querySelector(".titleContentForm").innerText = "Cập nhập sản phẩm";
    document
      .querySelector(".content_firstLeft")
      .querySelector(".form-select-wrap")
      .classList.remove("active");
  } else {
    document
      .querySelector(".content_firstLeft")
      .querySelector(".titleContentForm").innerText = "Thêm sản phẩm mới";

    document
      .querySelector(".content_firstLeft")
      .querySelector(".form-select-wrap")
      .classList.add("active");
  }
}

function runformUpdate(index) {
  document
    .getElementById("formUpdate")
    .addEventListener("submit", function (event) {
      event.preventDefault();

      const objValidateform = validateform("formUpdate", "list-attb-FormUpd");
      // for (var [key, value] of objValidateform.form.entries()) {
      //   console.log(key + ": " + value);
      // }

      objValidateform.form.append("btnUpdate", "true");

      if (!objValidateform.checkEmtpy) {
        $.ajax({
          type: "post",
          data: objValidateform.form,
          url: "handleProduct.php",
          processData: false,
          contentType: false,
          success: function (response) {
            // update name catregory in html

            changeBodyFormLeft();
          },
        });
      }
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
