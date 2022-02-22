const monthlyField = document.getElementById("monthly");
const totalField = document.getElementById("total");

const start_num = document.getElementById("start_num");
const final_num = document.getElementById("final_num");
const rate = document.getElementById("rate");

getMonthly();
getTotal();

start_num.addEventListener("click", getMonthly);
final_num.addEventListener("input", getMonthly);
start_num.addEventListener("click", getTotal);
final_num.addEventListener("input", getTotal);
rate.addEventListener("input", getTotal);

var monthly;
var total;

function getMonthly() {
    monthly = final_num.value - start_num.value;
    monthlyField.value = monthly;
}

function getTotal() {
    total = monthly * rate.value;
    totalField.value = Number((total).toFixed(2));
}