document
  .getElementById("formAddCategory")
  .addEventListener("submit", function (event) {
    $.ajax({
      type: "post",
      data: $(this).serialize() + `&btnAddCategoryNew=true`,
      url: "handleCategory.php",
      success: function (response) {
        // add category new to list of categories
        const inputNewNameCTGR = document.getElementById("IpCtgrName").value;
        if (inputNewNameCTGR) {
          let lastChildrowCategories = document.querySelector(
            ".rowCategories:last-child"
          );
          if (lastChildrowCategories) {
            const cloneElement = lastChildrowCategories.cloneNode(true);
            let idnew =
              +lastChildrowCategories.querySelector(".orderCTGR").innerText + 1;
            cloneElement.querySelector(".orderCTGR").innerText = idnew;

            cloneElement.querySelector(".InputCategoryName").innerText =
              inputNewNameCTGR;
            cloneElement
              .querySelector(".formChangeEachCategory")
              .querySelector(".idCategoryUPD").value = idnew;
            cloneElement
              .querySelector(".formChangeEachCategory")
              .querySelector(".CategoryNameUPD").value = inputNewNameCTGR;

            lastChildrowCategories.parentNode.appendChild(cloneElement);
          } else {
            let html = `<tr class="rowCategories">
                          <th class="align-middle orderCTGR" scope="row">1</th>
                          <td class="align-middle" colspan="2">
                              <div class="text-left InputCategoryName">
                                  ${inputNewNameCTGR}
                              </div>
                          </td>
                          <td class="align-middle">
                              <form class="formChangeEachCategory">
                                  <div class="row d-grid m-0">
                                      <div class="col-md-6">
                                          <input type="submit" data-inputName="update" name="btnUpdateCategory" value="Cập nhập" class="col text-center btn btn-primary btn-full" placeholder="Server" aria-label="Server">
                                          <input type="hidden" name="idCategory" class="idCategoryUPD" value="1">
                                          <input type="hidden" name="statusBtn" value="" class="statusBtn">
                                          <input type="hidden" name="CategoryName" class="CategoryNameUPD" value="${inputNewNameCTGR}" class="CategoryName">
                                      </div>
                                      <div class="col m-2 m-md-0 d-md-none"></div>
                                      <div class="col-md-6">
                                          <input type="submit" data-inputName="delete" name="btnDeleteCategory" value="Xoá" class="col text-center btn btn-secondary" placeholder="Username" aria-label="Username">
                                      </div>
                                  </div>
                              </form>
                          </td>
                        </tr>`;

            document.querySelector(".TableBodyListCategories").innerHTML = html;
            document
              .querySelectorAll(".rowCategories")
              .forEach((element, index) => {
                element.querySelector(".orderCTGR").innerText = index + 1;
              });
          }

          runformChangeEachCategory();
          document.getElementById("formAddCategory").reset();
        }
      },
    });
    event.preventDefault();
  });

runformChangeEachCategory();

function runformChangeEachCategory() {
  document
    .querySelectorAll(".formChangeEachCategory")
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
          data: $(this).serialize() + (check ? "" : "&btnDeleteCategory=true"),
          url: "handleCategory.php",
          success: function (response) {
            changeFormLeftCategory(
              element.querySelector(".statusBtn").value,
              element.querySelector(".CategoryNameUPD").value,
              element.querySelector(".idCategoryUPD").value
            );

            if (check) {
              console.log(this.data);
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

function changeFormLeftCategory(statusBtn = "", inputValue = "", id = -1) {
  // console.log(statusBtn + " " + inputValue + " " + index);
  let html = "";
  if (statusBtn == "update") {
    html = `
        <div class="p-1">
        <h4>Cập nhật danh mục</h4>
        </div>

        <form id="formUpdateCategory" action="">
            <div class="form-group">
                <input type="text" class="form-control" id="IpCtgrName" name="IpCtgrName" value="${inputValue}" placeholder="Nhập tên danh mục...">
                <input type="hidden" name="idCategoryUpdate" value="" class="idCategoryUpdate">
                </div>
            <div class="form-group text-left ">
                <input type="submit" class="btn btn-primary" id="btnUpdateCategoryNew" name="btnUpdateCategoryNew" value="Cập nhập" />
            </div>
        </form>
        `;
  } else {
    html = `
        <div class="p-1">
            <h4>Thêm danh mục</h4>
        </div>

        <form id="formAddCategory" action="">
            <div class="form-group">
              <input type="text" class="form-control" id="IpCtgrName" name="IpCtgrName" value="" placeholder="Nhập tên danh mục...">
            </div>
            <div class="form-group text-left ">
              <input type="submit" class="btn btn-primary" id="btnAddCategoryNew" name="btnAddCategoryNew" value="Thêm danh mục" />
            </div>
        </form>
        `;
  }
  document.querySelector(".content-firstCategory").innerHTML = html;
  document.getElementById("formUpdateCategory") &&
    (document
      .getElementById("formUpdateCategory")
      .querySelector(".idCategoryUpdate").value = id);
}

function runformUpdate(index) {
  document
    .getElementById("formUpdateCategory")
    .addEventListener("submit", function (event) {
      $.ajax({
        type: "post",
        data: $(this).serialize() + `&btnUpdateCategoryNew=true`,
        url: "handleCategory.php",
        success: function (response) {
          // update name catregory in html
          document
            .querySelectorAll(".rowCategories")
            [index].querySelector(".InputCategoryName").innerText =
            document.getElementById("IpCtgrName").value;
          changeFormLeftCategory();
        },
      });
      event.preventDefault();
    });
}

function runformDelete(element) {
  let index = Array.from(
    document.querySelectorAll(".formChangeEachCategory")
  ).indexOf(element);
  document.querySelectorAll(".rowCategories")[index].remove();
  document.querySelectorAll(".rowCategories").forEach((element, index) => {
    element.querySelector(".orderCTGR").innerText = index + 1;
  });
}

document.querySelectorAll(".rowCategories").forEach((element, index) => {
  element.querySelector(".orderCTGR").innerText = index + 1;
});

console.log(document.querySelectorAll(".rowCategories"));

// bản cũ
