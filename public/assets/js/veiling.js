$("#biddingInput").on("change paste keyup", element => {
    let price = element.target.value;
    console.log(price);
});