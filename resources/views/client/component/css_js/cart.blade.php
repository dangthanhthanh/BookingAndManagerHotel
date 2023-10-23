<script>
    function getAllLocal(itemTable) {
        let cartItems = JSON.parse(localStorage.getItem(itemTable)) || [];
        return cartItems;
    };
    function formatNumberWithDots(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    };
    function convertSnakeCaseToTitleCase(inputString) {
        const words = inputString.split('_');
        const capitalizedWords = words.map(word => word.charAt(0).toUpperCase() + word.slice(1));
        const titleCaseString = capitalizedWords.join(' ');
        return titleCaseString;
    };
    function displayCartItems(itemTable) {
        let cartItems = getAllLocal(itemTable);
        let container = document.getElementById('cart_'+itemTable+'_container');
        let buttonContainer = document.getElementById('cart_book_button_container');

        container.innerHTML = ` <div class="p-2">
            <h4>${convertSnakeCaseToTitleCase(itemTable)}</h4>
                <div class="d-flex flex-row align-items-center pull-right">
                    ${(!cartItems.length ? "You have not chosen any product" : "")}
                </div>
            </div>`;
        if(cartItems.length){
            buttonContainer.innerHTML = ` <button class="btn btn-block btn-lg ml-2 pay-button" type="button" id="proceed_to_pay">Proceed to Pay</button>`;
        };
        cartItems.forEach(item => {
        let itemDiv = document.createElement('div');
        itemDiv.className = 'd-flex flex-row justify-content-between align-items-center p-2 bg-white mt-4 px-3 rounded';
        let img = document.createElement('img');
        img.className = 'rounded';
        img.src = item.image;
        img.width = 70;

        let productDetails = document.createElement('div');
        productDetails.className = 'd-flex flex-column align-items-center product-details';
        productDetails.innerHTML = `<span class="font-weight-bold">${item.name}</span>`;

        let qtyDiv = document.createElement('div');
        qtyDiv.className = 'd-flex flex-row align-items-center qty';

        let minusButton = document.createElement('button');
        minusButton.innerHTML = '<i class="fa fa-minus text-danger"></i>';
        minusButton.addEventListener('click', () => decreaseQuantity(itemTable, item.id));
        qtyDiv.appendChild(minusButton);

        let quantityElement = document.createElement('h5');
        quantityElement.className = 'text-grey mt-1 mr-1 ml-1';
        quantityElement.textContent = item.quantity;

        let plusButton = document.createElement('button');
        plusButton.innerHTML = '<i class="fa fa-plus text-success"></i>';
        plusButton.addEventListener('click', () => increaseQuantity(itemTable, item.id));
        qtyDiv.appendChild(quantityElement);
        qtyDiv.appendChild(plusButton);

        let costDiv = document.createElement('div');
        costDiv.innerHTML = `<h5 class="text-grey">${formatNumberWithDots(item.cost)} vnd</h5>`;

        let deleteIcon = document.createElement('div');
        deleteIcon.innerHTML = '<i class="fa fa-trash mb-1 text-danger" onclick="deleteItemLocally(\'' + itemTable + '\', \'' + item.id + '\')"></i>';

        itemDiv.appendChild(img);
        itemDiv.appendChild(productDetails);
        itemDiv.appendChild(qtyDiv);
        itemDiv.appendChild(costDiv);
        itemDiv.appendChild(deleteIcon);

        container.appendChild(itemDiv);
        });
    };
    function increaseQuantity(itemTable, itemId) {
        modifyQuantity(itemTable, itemId, 1);
    };

    function decreaseQuantity(itemTable, itemId) {
        modifyQuantity(itemTable, itemId, -1);
    };

    function modifyQuantity(itemTable, itemId, change) {
        let cartItems = getAllLocal(itemTable);
        let item = cartItems.find(item => item.id === itemId);

        if (item) {
            item.quantity += change;
            if (item.quantity < 1) {
                // Ensure quantity doesn't go below 1
                item.quantity = 1;
            }
        }

        localStorage.setItem(itemTable, JSON.stringify(cartItems));
        displayCartItems(itemTable);
    };

    function deleteItemLocally(itemTable, itemId) {
        let cartItems = getAllLocal(itemTable);
        let updatedCart = cartItems.filter(item => item.id !== itemId);
        localStorage.setItem(itemTable, JSON.stringify(updatedCart));
        displayCartItems(itemTable);
    };
    displayCartItems('book_food');
    displayCartItems('book_service');
    displayCartItems('book_event');
</script>
<script>
    function sendDataToServer(data) {
        $.ajax({
            url: "{{ route('auth.account.cart.serve') }}",
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(data),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            success: function(response) {
                console.log('Request successful:', response);
                if(response.status === 'true'){
                    deletedAllLocal();
                    window.location.href = "{{route('auth.account.checkout')}}";
                }else{
                    // refreshAllLocal();
                    console.error('The product is no longer available, please choose another product that works, contact 1234567890 for help');
                }
            },
            error: function(error) {
                console.error('Error in request:', error);
            }
        });
    }
    function deletedAllLocal() {
        localStorage.clear();
    };

    function getAllLocalValues() {
        const allLocalValues = [];
        allLocalValues.push({'book_event':getAllLocal('book_event')});
        allLocalValues.push({'book_food':getAllLocal('book_food')});
        allLocalValues.push({'book_service':getAllLocal('book_service')});
        return allLocalValues;
    }
    $(document).ready(function() {
        if (getAllLocal('book_event').length || getAllLocal('book_service').length || getAllLocal('book_food').length) {
            $('#proceed_to_pay').show();
        }else{
            $('#proceed_to_pay').hide();
        };  
        $('#proceed_to_pay').on('click', function() {
            const localValues = getAllLocalValues();
            sendDataToServer(localValues);
        });
    });
</script>