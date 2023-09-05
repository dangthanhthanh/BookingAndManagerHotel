<script>
    $(document).ready(function() {
        $("#list_button_order_payment").hide();
        $("#order_payment_method").hide();
        $("#cash_payment_table").hide();
        var selectedProducts = [];
        let table = "{{$table}}";
        let localData = localStorage.getItem(table + "_booking")
        if (localData !== null && localData.length > 0) {
            selectedProducts = JSON.parse(localData);
            updateTable();
        }
        $(".add").click(function() {
            let productId = $(this).data("id");
            let productName = $(this).data("name");
            let productCost = $(this).data("cost");
            // console.log(productId,productName,productCost);
            var existingProductIndex = selectedProducts.findIndex(function(item) {
                return item.productId === productId;
            });
            if (existingProductIndex !== -1) {
                selectedProducts[existingProductIndex].quantity++;
            } else {
                selectedProducts.push({
                    productId: productId,
                    productName: productName,
                    productCost: productCost,
                    quantity: 1
                });
            }
            console.log("Selected Products:", selectedProducts);
            updateTable();
        });
        function updateTable() {
            console.log(selectedProducts);
            let totalCost=0;
            let totalQty=0;
            var tableHtml = `<thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col" class="product-quantity" width="120">Qty</th>
                                    <th scope="col" width="120">Price</th>
                                    <th scope="col" >Delete</th>
                                </tr>
                            </thead>
                            <tbody>`;
    
            selectedProducts.forEach(function(product) {
                totalCost += product.quantity*product.productCost;
                totalQty += product.quantity;
                tableHtml +=  `<tr>
                                    <td class="custom-text-center custom-text-justify">
                                        <div class="btn-group">
                                            <h6 class="btn btn-outline">`+product.productName+`</h6>
                                        </div>
                                    </td class="custom-text-center custom-text-justify">
                                    <td class="text-center product-quantity">
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-outline-secondary decrease" data-id="`+product.productId+`"><i class="fa fa-minus"></i></button>
                                            <button type="button" class="btn btn-outline">`+product.quantity+`</button>
                                            <button type="button" class="btn btn-outline-primary increase" data-id="`+product.productId+`"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td class="custom-text-center custom-text-justify">
                                        <div class="btn-group">
                                            <var class="btn btn-outline">
                                                    `+product.productCost*product.quantity+`
                                            </var>
                                        </div>
                                    </td>
                                    <td class="custom-text-center custom-text-justify">
                                        <a href="#" class="btn btn-outline-danger deleted-item"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>`
                            }); 
    
                tableHtml += `<tfoot>
                                <tr>
                                    <th scope="col">Total:_</th>
                                    <td scope="col" class="product-quantity">`+totalQty+`</td>
                                    <td scope="col">`+totalCost+`</td>
                                    <td scope="col">Vnd</td>
                                </tr>
                            </tfoot>
                        </tbody>`;
    
            $("#order-table-list").html(tableHtml);
            updateQuantityInTable();
            deletedItem();
            buttonHandlerInSidebar();
            $("#order_save").click(function() {
                saveSelectedProductsToLocalStorage();
                // logLocalStorageContents();
            });
            $("#order_delete").click(function() {
                deleteSelectedProductsToLocalStorage()
            });
            updatePaymentFields(totalCost)
            $("#cashInput").on("input", function() {
                calculateOver();
            });

            if(table === 'room'){
                $(".product-quantity").hide();
            }else{
                $(".product-quantity").show();
            }
        };

         function deletedItem() {
            $(".deleted-item").click(function() {
                var rowIndex = $(this).closest("tr").index();
                selectedProducts[rowIndex].quantity=0;
                if (selectedProducts[rowIndex].quantity <= 0) {
                    selectedProducts.splice(rowIndex, 1);
                }
                updateTable();
            });
        };
    
        function updateQuantityInTable () {
            $(".decrease").click(function() {
                var rowIndex = $(this).closest("tr").index();
                selectedProducts[rowIndex].quantity--;
                if (selectedProducts[rowIndex].quantity <= 0) {
                    selectedProducts.splice(rowIndex, 1);
                }
                updateTable();
            });
    
            $(".increase").click(function() {
                var rowIndex = $(this).closest("tr").index();
                selectedProducts[rowIndex].quantity++;
                updateTable();
            });
        };
        function buttonHandlerInSidebar () {
            $("#list_button_order_payment").show();
    
            $("#order_payment").click(function() {
                $("#order_payment_method").show();
            });
    
            $("#cash_payment").click(function() {
                $("#cash_payment_table").show();
            });
        };
        function saveSelectedProductsToLocalStorage() {
            localStorage.setItem(table+'_booking', JSON.stringify(selectedProducts));
            sendDataToServer();
        };
        function logLocalStorageContents() {
            console.log("Local Storage contents for " + table + "_booking:", localStorage.getItem(table + "_booking"));
        };
        function deleteSelectedProductsToLocalStorage() {
            localStorage.removeItem(table + "_booking");
            selectedProducts = []; // Reset the selectedProducts array
            updateTable();
        };
        function deleteAllLocalStorage() {
            localStorage.clear();
            selectedProducts = []; // Reset the selectedProducts array
            updateTable();
        };
        function updatePaymentFields(totalCost) {
            $("#total_cost_for_payment").text(totalCost);
        }
        function calculateOver() {
            let cashReceived = parseFloat($("#cashInput").val());
            let totalCost = parseFloat($("#total_cost_for_payment").text());
            
            if (!isNaN(cashReceived)) {
                let overAmount = cashReceived - totalCost;
                $("#over_for_payment").text(overAmount + "_vnd");
            } else {
                $("#over_for_payment").text("Invalid Input");
            }
        }
        function sendDataToServer() {
            let datas = localStorage.getItem(table + "_booking");
            $.ajax({
                url: "{{ route('pos.payment.processLocalStorage').'?_token='.csrf_token() }}",
                type: "POST",
                data: {
                    table: table,
                    data: datas,
                },
                dataType: "json",
                success: function(response) {
                    console.log({
                    table: table,
                    data: datas,
                    });
                    console.log('sending data: true');
                },
                error: function(error) {
                    console.error("Error sending data:", error);
                }
            });
        };
    });
</script>