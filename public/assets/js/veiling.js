$("#biddingInput").on("change paste keyup", element => {
    const value = parseFloat(element.target.value) || null;
    const submitBtn = $("#submitBtn");

    if (value == null) submitBtn.attr("disabled", "disabled");
    else submitBtn.removeAttr("disabled");
});

$("#biddingInput").on("blur", element => {
    const inputVal = element.target.value;
    const minPrice = parseFloat(element.target.min);

    let parsed = parseFloat(minPrice, 10).toFixed(1);
    if (inputVal > minPrice) {
        parsed = parseFloat(inputVal, 10).toFixed(1);
    }
    $("#biddingInput").val(inputVal !== "" ? `${parsed}0` : null);
});
