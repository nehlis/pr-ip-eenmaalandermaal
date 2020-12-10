//? Verkrijg alle verplichte velden om tekst erbij te zetten
let requiredFields = document.getElementsByClassName("required-field");
Array.from(requiredFields).forEach(rf => {
    rf.className += " text-muted font-italic ml-1";
    rf.innerHTML = `(verplicht)`;
});

//? Scroll to top button
jQuery(() => {
    $(window).on("scroll", () => {
        if ($(this).scrollTop() > 50) $("#back-to-top").fadeIn();
        else $("#back-to-top").fadeOut();
    });
    $("#back-to-top").on("click", () => {
        $("body,html").animate(
            {
                scrollTop: 0,
            },
            400
        );
        return false;
    });
});

// Custom HTML Datalist (with value and label)
document.querySelector("input[list]").addEventListener("input", function (e) {
    console.log("TEST");
    var input = e.target,
        list = input.getAttribute("list"),
        options = document.querySelectorAll(`#${list} option`),
        hiddenInput = document.getElementById(
            input.getAttribute("id") + "-hidden"
        ),
        label = input.value;

    hiddenInput.value = label;

    for (let i = 0; i < options.length; i++) {
        var option = options[i];

        if (option.innerText === label) {
            hiddenInput.value = option.getAttribute("data-value");
            break;
        }
    }
});
