<script>
    $(document).ready(function() {
        $("#list_button_order_payment").hide();
        $("#order_payment_method").hide();
        $("#cash_payment_table").hide();
        var selectedProducts = [];
        const table = "room";
        let localData = localStorage.getItem(table + "_booking")
        if (localData !== null && localData.length > 0) {
            selectedProducts = JSON.parse(localData);
            updateTable();
        }
        $(".add").click(function() {
            const productId = $(this).data("id");
            const productName = $(this).data("name");
            const productCost = $(this).data("cost");
            const checkIn = "{{$checkDate['check_in']}}";
            const checkOut = "{{$checkDate['check_out']}}";
            const scort = parseFloat("{{$checkDate['cost_per']}}");
            
            selectedProducts.push({
                productId: productId,
                productName: productName,
                productCost: productCost,
                checkIn: checkIn,
                checkOut: checkOut,
                scort: scort,
            });

            console.log("Selected Products:", selectedProducts);
            updateTable();

            $(this).prop('disabled', true);;
        });
        function updateTable() {
            console.log(selectedProducts);
            let totalCostItem=0;
            let totalCost=0;
            var tableHtml = `<thead>
                                <tr>
                                    <th scope="col">Item</th>
                                    <th scope="col" style='min-width:150px;' class='check_in_date'>Check In</th>
                                    <th scope="col" style='min-width:150px;' class='check_out_date'>Check Out</th>
                                    <th scope="col" >Price</th>
                                    <th scope="col" >Delete</th>
                                </tr>
                            </thead>
                            <tbody>`;
    
            selectedProducts.forEach(function(product) {
                const { productId: id, productName: name, productCost: cost, checkIn: checkIn, checkOut: checkOut, scort: scort} = product;
                totalCostItem = cost*scort;
                totalCost += totalCostItem;

                tableHtml +=  `<tr>
                                    <td class="custom-text-center custom-text-justify">
                                        <div class="btn-group">
                                            <h6 class="btn btn-outline">`+name+`</h6>
                                        </div>
                                    </td class="custom-text-center custom-text-justify">
                                    <td class='check_in_date'>`+checkIn+`</td>`;
                                    
                //only room tab         
                tableHtml +=        `<td class='check_out_date'>`+checkOut+`</td>`;

                //total  item
                tableHtml +=        `<td class="custom-text-center custom-text-justify">
                                        <div class="btn-group">
                                            <var class="btn btn-outline">
                                                    `+totalCostItem+`
                                            </var>
                                        </div>
                                    </td>`;
                //delete
                tableHtml +=        `<td class="custom-text-center custom-text-justify">
                                        <a href="#" class="btn btn-outline-danger deleted-item"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>`;
                
                }); 

            //tfoot
            tableHtml += `<tfoot>
                            <tr>
                                <th scope="col">Total:_</th>
                                <td scope="col"></td>
                                <td scope="col"></td>
                                <td scope="col">`+totalCost+`</td>
                                <td scope="col">Vnd</td>
                            </tr>
                        </tfoot>
                    </tbody>`;
    
            $("#order-table-list").html(tableHtml);
            deletedItem();
            buttonHandlerInSidebar();
            $("#order_save").click(function() {
                saveSelectedProductsToLocalStorage();
            });
            $("#order_delete").click(function() {
                deleteSelectedProductsToLocalStorage();
            });
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