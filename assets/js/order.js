const $ = require('jquery');

$(document).ready(function () {
    $("#products").change(function() {
        let availableProductQuantity = $(this).children('option:selected').val().split("-")[1];
        $("#quantity").attr('max',availableProductQuantity);
    });

    $("#addToCart").click(()=>{
        const selectedProduct = $("#products").children("option:selected");
        const quantityInput = $("#quantity");
        const productName = selectedProduct.text();
        const productId = selectedProduct.val().split("-")[0];
        const quantity = quantityInput.val();
        const productBadge = $("<a></a>").addClass("btn btn-danger text-white mr-5").text(quantity + "-" + productName + "  ");
        $("#orderedProducts").append(productBadge);
        quantityInput.val(null);
        let productOption = $(`<option>${quantity}</option>`).val(productId+"-"+quantity);
        $("#ligneCmds").append(productOption);
    });
});

