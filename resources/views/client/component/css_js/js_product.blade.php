<script>
    function addToCart(event) {
        event.preventDefault();
        let itemTable = "{{$table}}";
        let itemId = event.target.getAttribute('data-id');
        let itemName = event.target.getAttribute('data-name');
        let itemCheckIn = event.target.getAttribute('data-checkin');
        let itemSlug = event.target.getAttribute('data-slug');
        let itemImage = event.target.getAttribute('data-image');
        let itemCost = event.target.getAttribute('data-cost');
        let itemQty = 1;

        let dataLocal = getAllLocal(itemTable);

        let existingItem = dataLocal.find(item => item.id === itemId);

        if (existingItem) {
            existingItem.quantity++;
            showConfirm('You have added 1 more quantity of the product to your cart.').then((result) => {
                if (result.isConfirmed) {
                    updateCartLocally(itemTable, dataLocal);
                    showAlert('You have added 1 more quantity of the product to your cart.');
                };
            });
        } else {
            showConfirm('Do you want to add a new product to your cart?').then((result) => {
                if (result.isConfirmed) {
                    addToCartLocally(itemTable, itemId, itemName, itemCheckIn, itemSlug, itemImage, itemCost, itemQty);
                    showAlert('You have added a new product to your cart.');
                };
            });
        }
    }

    function addToCartLocally(itemTable, itemId, itemName, itemCheckIn, itemSlug, itemImage, itemCost, itemQty) {
        let cartItems = JSON.parse(localStorage.getItem(itemTable)) || [];
        let newItem = {
            id: itemId,
            name: itemName,
            checkin: itemCheckIn,
            slug: itemSlug,
            image: itemImage,
            cost: itemCost,
            quantity: itemQty
        };
        cartItems.push(newItem);
        localStorage.setItem(itemTable, JSON.stringify(cartItems));
    }

    function updateCartLocally(itemTable, updatedCart) {
        localStorage.setItem(itemTable, JSON.stringify(updatedCart));
    }

    function getAllLocal(itemTable) {
        let cartItems = JSON.parse(localStorage.getItem(itemTable)) || [];
        return cartItems;
    }

    function showAlert(message) {
        Swal.fire({
            text: message,
            showConfirmButton: false,
            timer: 1000,
            position: 'top-end',
        });
    }
    function showConfirm(message) {
        return Swal.fire({
            text: message,
            icon: 'question',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            position: 'top-end',
        });
    }
</script>
