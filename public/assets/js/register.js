var listItemElement = document.getElementById("phoneNumberList");

var phoneNumbers = [];
addPhoneNumber();
renderPhoneNumberElements();

function makeId() {
  return (
    Math.random().toString(36).substring(2, 15) +
    Math.random().toString(36).substring(2, 15)
  );
}

function changePhoneNumber(event, id) {
  let newNumber = event.target.value;
  let itemToChange = phoneNumbers.findIndex((pn) => pn._id === id);
  phoneNumbers[itemToChange].number = newNumber;
}

function addPhoneNumber() {
  let phoneNumber = { _id: makeId(), number: "" };
  phoneNumbers.push(phoneNumber);
  renderPhoneNumberElements();
}

function removePhoneNumber(id) {
  phoneNumbers = phoneNumbers.filter(
    (pn) => pn._id.toString() !== id.toString()
  );
  renderPhoneNumberElements();
}

function makePhoneNumberElement(phoneNum, index) {
  return `
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fa fa-phone"></i>&nbsp;${
              index + 1
            }</div>
        </div>
        <input type="tel" name="phoneNumbers[]" class="form-control" id="phone${index}" placeholder="+31 6 12345678" value="${
    phoneNum.number
  }" onblur="changePhoneNumber(event, \'${phoneNum._id}\')">
    ${
      phoneNumbers.length > 1 && index !== 0
        ? `<div class="input-group-append">
            <button class="btn btn-outline-danger" type="button" onclick="removePhoneNumber(\'${phoneNum._id}\')"><i class="fa fa-times"></i></button>
        </div>`
        : ""
    }
    </div>`;
}

function renderPhoneNumberElements() {
  listItemElement.innerHTML = "";
  phoneNumbers.forEach(
    (phoneNumber, index) =>
      (listItemElement.innerHTML += makePhoneNumberElement(phoneNumber, index))
  );
}
