import Chart from "chart.js/auto";

$(function () {
    $.ajax({
        type: "GET",
        url: route("admin.sales_analytics.index"),
        success(response) {
            let data = {
                labels: response.labels,
                sales: [],
                formatted: [],
                totalOrders: [],
            };

            for (let item of response.data) {
                data.sales.push(item.total.amount);
                data.formatted.push(item.total.formatted);
                data.totalOrders.push(item.total_orders);
            }

            initSalesAnalyticsChart(data);
        },
    });
});

function initSalesAnalyticsChart(data) {
    new Chart($(".sales-analytics .chart"), {
        type: "bar",
        data: {
            labels: data.labels,
            datasets: [
                {
                    data: data.sales,
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.5)",
                        "rgba(54, 162, 235, 0.5)",
                        "rgba(255, 206, 86, 0.5)",
                        "rgba(75, 192, 192, 0.5)",
                        "rgba(153, 102, 255, 0.5)",
                        "rgba(255, 159, 64, 0.5)",
                    ],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: false,
                tooltip: {
                    displayColors: false,
                    callbacks: {
                        label(item) {
                            let orders = `${trans(
                                "admin::dashboard.sales_analytics.orders"
                            )}: ${data.totalOrders[item.dataIndex]}`;

                            let sales = `${trans(
                                "admin::dashboard.sales_analytics.sales"
                            )}: ${data.formatted[item.dataIndex]}`;

                            return [orders, sales];
                        },
                    },
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Include the currency symbol in the ticks
                        callback: function (value) {
                            return data.formatted[0].charAt(0) + value;
                        },
                    },
                },
            },
        },
    });
}
