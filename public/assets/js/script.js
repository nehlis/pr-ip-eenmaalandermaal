//? Verkrijg alle verplichte velden om tekst erbij te zetten
let requiredFields = document.getElementsByClassName("required-field");
console.log("🚀 ~ file: script.js ~ line 3 ~ requiredFields", requiredFields)
Array.from(requiredFields).forEach((rf) => {
    rf.className += " text-muted font-italic ml-1"
    rf.innerHTML = `(verplicht)`;
});
