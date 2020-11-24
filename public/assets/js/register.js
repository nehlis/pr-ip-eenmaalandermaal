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

function addPhoneNumber() {
    let phoneNumber = { _id: makeId(), number: "2" };
    phoneNumbers.push(phoneNumber);
    renderPhoneNumberElements();
}

function removePhoneNumber(_id) {
    console.log("🚀 ~ file: register.js ~ line 21 ~ removePhoneNumber ~ _id", _id)
    phoneNumbers = phoneNumbers.filter((pn) => pn._id !== _id);
}

function makePhoneNumberElement(phoneNum, index) {
    console.log(
        "🚀 ~ file: register.js ~ line 27 ~ makePhoneNumberElement ~ phoneNum",
        phoneNum
    );
    return `
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fa fa-phone"></i>&nbsp;${
                index + 1
            }</div>
        </div>
        <input type="text" class="form-control" id="phone${index}" placeholder="+31 6 12345678" value="${
        phoneNum.number
    }">
        <div class="input-group-append">
            <button class="btn btn-outline-danger" type="button" onclick="removePhoneNumber("${phoneNum._id}");"><i class="fa fa-times"></i></button>
        </div>
    </div>`;
}

function renderPhoneNumberElements() {
    listItemElement.innerHTML = "";
    phoneNumbers.forEach(
        (phoneNumber, index) =>
            (listItemElement.innerHTML += makePhoneNumberElement(
                phoneNumber,
                index
            ))
    );
}
