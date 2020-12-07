$("#biddingInput").on("blur", element => {
    let inputPrice = element.target.value;
    let minPrice = parseFloat(element.target.min);

    let parsed = parseFloat(minPrice, 10).toFixed(1);
    if (inputPrice > minPrice) {
        parsed = parseFloat(inputPrice, 10).toFixed(1);
    }
    $("#biddingInput").val(parsed + "0");
});
