//? Verkrijg alle verplichte velden om tekst erbij te zetten
let requiredFields = document.getElementsByClassName("required-field");
Array.from(requiredFields).forEach((rf) => {
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
