$(document).ready(function(){
    searchProduct();
    loadPaginatedProducts();
})

function displayError(message){
    $("#display-error").html(`<span class="alert alert-danger" style="margin-top: -40px;">${message}</span>`);
}

function searchProduct(){
    $("#search-button").on('click', async function(){
        const query = $("#product-search").val().trim();

        
        if(!query || isNaN(query)){
            displayError("Please enter a valid number for price search.");
        } else {
            try {
                const response = await fetch(`/api/product-search?product-search=${query}`);

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const products = await response.json();

                console.log("Products returned:", products); // Debugging

                if(products.length === 0){
                    displayError("No Product Found.");
                    displayNotFound();
                } else {
                    loadProducts(products);
                }
            } catch (error) {
                console.error("Error fetching product:", error);
                displayError("There was an error with your search. Please try again.");
            }
        }
    });
}


function displayNotFound(){
    var row = `
        <tr>
            <td colspan="5">Product not found</td>
        </tr>
    `;

    $("tbody").html(row);
}

async function loadPaginatedProducts(page = 1){
    try {
        const response = await fetch(`/?page=${page}`);
        const products = await response.json();

        loadProducts(products);

    } catch (error) {
        //console.error("Error paginating products", error);
    }
}


function loadProducts(products){
    var rows = '';

    $.each(products, function(index, product){
        rows += `
        <tr>
            <th scope="col">${product.id}</th>
            <td>${product.product_name}</td>
            <td>${product.description}</td>
            <td>${product.price}</td>
            <td>${product.quantity}</td>
        </tr>
        `;
    })

    $('tbody').html(rows);
}
