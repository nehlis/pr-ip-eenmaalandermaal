const listItemElement = document.getElementById("phoneNumberList");
// prettier-ignore
var phoneNumbers = [];

const makeId = () =>
    Math.random().toString(36).substring(2, 15) +
    Math.random().toString(36).substring(2, 15);

const changePhoneNumber = ({ target: { value = "" } }, id) => {
    let itemToChange = phoneNumbers.findIndex((pn) => pn._id === id);
    if (itemToChange > -1)
        phoneNumbers[itemToChange].number = value.replace(/[^+0-9]/g, "");
    renderPhoneNumberElements();
};

const addPhoneNumber = () => {
    let phoneNumber = { _id: makeId(), number: "" };
    phoneNumbers.push(phoneNumber);
    renderPhoneNumberElements();
};

const removePhoneNumber = (id) => {
    phoneNumbers = phoneNumbers.filter(function (pn) {
        return pn._id !== id;
    });
    renderPhoneNumberElements();
};

const makePhoneNumberElement = (phoneNum, index) => `
    <div class="input-group mb-2">
        <div class="input-group-prepend">
            <div class="input-group-text"><i class="fa fa-phone"></i></div>
        </div>
        <input required="true" type="tel" name="phoneNumbers[]" class="form-control" id="phone${index}" placeholder="+31 6 12345678" value="${
            phoneNum.number
        }" onblur="changePhoneNumber(event, \'${phoneNum._id}\')">
        ${
            phoneNumbers.length > 1 && index !== 0
        ? ` <div class="input-group-append">
                <button class="btn btn-outline-danger" type="button" onclick="removePhoneNumber(\'${phoneNum._id}\')"><i class="fa fa-times"></i></button>
            </div>`
        : ""
        }
    </div>`;

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

addPhoneNumber();
renderPhoneNumberElements();
