let CardsProductHot = document.querySelectorAll(".card_product_hot");
CardsProductHot = Array.from(CardsProductHot).slice(
  0,
  CardsProductHot.length - 1
);
CardsProductHot.forEach((element) => {
  element.classList.add("my-4");
});

const ListNumberInput = document.querySelectorAll("input.numberInput");
const btnsDecrease = document.querySelectorAll(".btnDecrease");
const btnsIncrease = document.querySelectorAll(".btnIncrease");

btnsIncrease.forEach((element, index) => {
  element.addEventListener("click", () => {
    let value = parseInt(ListNumberInput[index].getAttribute("value"), 10);
    let pricePRD = document.querySelectorAll(".PriceProduct")[index].innerHTML;
    let totalPrce = document.querySelectorAll(".total")[index];
    let btnACTION = document.querySelectorAll(".btnACT")[index];
    pricePRD = parseInt(pricePRD.replace(/\./g, ""));

    value = isNaN(value) ? 0 : value;
    value++;

    ListNumberInput[index].setAttribute("value", value.toString());
    totalPrce.innerHTML = `${(value * pricePRD).toLocaleString()}`;
    btnACTION.setAttribute("value", "increase");
  });
});

btnsDecrease.forEach((element, index) => {
  element.addEventListener("click", () => {
    let value = parseInt(ListNumberInput[index].getAttribute("value"), 10);
    let pricePRD = document.querySelectorAll(".PriceProduct")[index].innerHTML;
    let totalPrce = document.querySelectorAll(".total")[index];
    pricePRD = parseInt(pricePRD.replace(/\./g, ""));
    let btnACTION = document.querySelectorAll(".btnACT")[index];

    value = isNaN(value) ? 1 : value;
    value--;
    value < 1 ? (value = 1) : "";

    ListNumberInput[index].setAttribute("value", value.toString());
    totalPrce.innerHTML = `${(value * pricePRD).toLocaleString()}`;
    btnACTION.setAttribute("value", "decrease");
  });
});
