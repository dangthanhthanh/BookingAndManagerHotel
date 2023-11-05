{{-- @php
    dd($data);
@endphp --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Parse the data and timeline
        const data = JSON.parse('{{json_encode($data)}}'.replace(/&quot;/g, '"'));
        const timeLine = '{{$timeLine}}';
        
        // Define a function to get counts based on a specific field
        function getCountByField(times, field) {
            const result = times.map((time) => {
                return data.filter((item) => item.created_at === time).length;
            });
            return result;
        };

        // Define a function to get the sum of a specific field
        function getSumByField(times, field) {
            const result = times.map((time) => {
                return data
                    .filter((item) => item.created_at === time)
                    .reduce((sum, item) => sum + item[field], 0);
            });
            return result;
        };

        // Define a function to get an array of days in the past year
        function getTime() {
            const now = new Date();
            const startDate = new Date(now);

            switch (timeLine) {
                case 'today':
                    startDate.setDate(now.getDate() - 1);
                    return generateTimeArray(startDate, now, 'hour');

                case 'week':
                    startDate.setDate(now.getDate() - 7);
                    return generateTimeArray(startDate, now, 'day');

                case 'month':
                    startDate.setMonth(now.getMonth() - 1);
                    return generateTimeArray(startDate, now, 'day');

                case 'year':
                    startDate.setFullYear(now.getFullYear() - 1);
                    return generateTimeArray(startDate, now, 'day');

                default:
                    return [];
            };
        };

        function generateTimeArray(startDate, endDate, unit) {
            const timeArray = [];
            while (startDate <= endDate) {
                timeArray.push(formatDate(new Date(startDate)));
                if (unit === 'hour') {
                    startDate.setHours(startDate.getHours() + 1);
                } else {
                    startDate.setDate(startDate.getDate() + 1);
                }
            }
            return timeArray;
        };

        //'d/m/Y' format validate with data
        function formatDate(date) {
            const day = date.getDate().toString().padStart(2, '0');
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        };

        // Define the time categories
        const timeCategories = getTime();
        // Get counts and sums for sales, revenue, and customers
        const salesData = getCountByField(timeCategories, 'sales');
        const revenueData = getSumByField(timeCategories, 'balance');
        const customerData = getCountByField(timeCategories, 'customer');

        
        new ApexCharts(document.querySelector("#reportsChart"), {
            series: [{
                name: 'Revenue',
                data: revenueData
            }],
            xaxis: {
            type: 'date',
            categories: timeCategories
            },
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: true
                },
            },
            markers: {
                size: 1
            },
            colors: ['#4154f1'],
            fill: {
                type: "gradient",
                gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.4,
                stops: [0, 90, 100]
            }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            tooltip: {
                x: {    
                    format: 'd/m/Y'
                },
            }
        }).render();
        new ApexCharts(document.querySelector("#registerChart"), {
            series: [{
                name: 'Sales',
                data: salesData,
            }, {
                name: 'Customers',
                data: customerData
            }],
            xaxis: {
                type: 'date',
                categories: timeCategories
            },
            chart: {
                height: 300,
                type: 'area',
                toolbar: {
                    show: true
                },
            },
            markers: {
            size: 1
            },
            colors: ['#4154f1', '#2eca6a'],
            fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.3,
                opacityTo: 0.4,
                stops: [0, 90, 100]
            }
            },
                dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            tooltip: {
                x: {    
                    format: 'd/m/Y'
                },
            }
        }).render();
    });
</script>