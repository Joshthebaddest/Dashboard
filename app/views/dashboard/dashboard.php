<?php  
    $allowed_roles = ['admin', 'editor', 'user'];
    $role_hierarchy = [
        'super_admin' => 4,
        'admin'       => 3,
        'editor'      => 2,
        'user'        => 1,
    ];

    $activities = [
        [
            "id" => 1,
            "type" => 'auth',
            "description" => 'Successful login from IP 192.168.1.1',
            "timestamp" => '2024-03-15T10:30:00Z',
            "icon" => "shield",
            "status" => 'success'
        ],
        [
            "id" => 2,
            "type" => 'user',
            "description" => 'New user registered: john@example.com',
            "timestamp" => '2024-03-15T09:45:00Z',
            "icon" => "user-plus",
            "status" => 'success'
        ],
        [
            "id" => 3,
            "type" => 'settings',
            "description" => 'OAuth settings updated for App: E-commerce',
            "timestamp" => '2024-03-15T09:30:00Z',
            "icon" => "settings",
            "status" => 'info'
        ],
        [
            "id" => 4,
            "type" => 'auth',
            "description" => 'Failed login attempt from IP 203.0.113.1',
            "timestamp" => '2024-03-15T09:15:00Z',
            "icon" => "alert-triangle",
            "status" => 'error'
        ]
    ];
?>

<div>
    <h3 class="text-center font-bold text-3xl">Dashboard</h3>

    <div class="flex gap-5 flex-wrap py-10">
        <div style="width: 250px" class='shadow-md border rounded-xl p-5 bg-white'>
            <div class="flex items-center justify-between">
                <div>
                    <p class='font-semibold text-sm'>Total Earnings</p>
                </div>
                <div class="p-3 bg-pink-50 rounded-lg">
                    <i class="w-6 h-6 text-pink-600" data-lucide="wallet"></i>
                </div>
            </div>
            <div class='text-xl  font-bold'>
                <p>$400</p>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span class="text-green-600">20%</span> vs last month
            </div>
        </div>
        
        <div style="width: 250px" class='shadow-md border rounded-xl p-5 bg-white'>
            <div class="flex items-center justify-between">
                <div>
                    <p class='font-semibold text-sm'>Total Users</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <i class="w-6 h-6 text-green-600" data-lucide="users"></i>
                </div>
            </div>
            <div class='text-xl  font-bold'>
                <p>4</p>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span class="text-green-600">2%</span> vs last month
            </div>
        </div>
        <div style="width: 250px" class='shadow-md border rounded-xl p-5 bg-white'>
            <div class="flex items-center justify-between">
                <div>
                    <p class='font-semibold text-sm'>Total Products</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg">
                    <i class="w-6 h-6 text-indigo-600" data-lucide="package"></i>
                </div>
            </div>
            <div class='text-xl  font-bold'>
                <p>20</p>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span class="text-green-600">45%</span> vs last month
            </div>
        </div>
        <div style="width: 250px" class='shadow-md border rounded-xl p-5 bg-white'>
            <div class="flex items-center justify-between">
                <div>
                    <p class='font-semibold text-sm'>Total Orders</p>
                </div>
                <div class="p-3 bg-red-50 rounded-lg">
                    <i class="w-6 h-6 text-red-600" data-lucide="shopping-cart"></i>
                </div>
            </div>
            <div class='text-xl  font-bold'>
                <p>3</p>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span class="text-green-600">15%</span> vs last month
            </div>
        </div>
        <div style="width: 250px" class='shadow-md border rounded-xl p-5 bg-white'>
            <div class="flex items-center justify-between">
                <div>
                    <p class='font-semibold text-sm'>Total Vendors</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i class="w-6 h-6 text-blue-600" data-lucide="users-round"></i>
                </div>
            </div>
            <div class='text-xl  font-bold'>
                <p>3</p>
            </div>
            <div class="mt-3 text-xs text-gray-500">
                <span class="text-green-600">15%</span> vs last month
            </div>
        </div>
    </div>

    <div class='py-10 space-y-5 text-white'>
        <a href="users" class="flex gap-2 items-center bg-gray-800 rounded-lg w-48 p-2 px-5">
            <i class="w-5 h-5 text-white" data-lucide="external-link"></i>
            View Users
        </a>

        <a href="products" class="flex gap-2 items-center bg-gray-800 rounded-lg w-48 p-2 px-5">
            <i class="w-5 h-5 text-white" data-lucide="external-link"></i>
            View Products
        </a>
    </div>

    <div class="flex gap-5">
        <div style="width: 500px;">
            <div class="bg-white p-5 rounded-lg shadow-lg">
                <div class="pb-10 flex justify-between">
                    <div class="flex mb-4">
                        <h2 class="text-lg font-semibold mt-2">Revenue Report</h2>
                    </div>

                    <div class="flex justify-between">
                        <div class="relative inline-block w-32 text-sm">
                            <select id="periodSelector" class="w-full appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                                <option value="7days">Last 7 Days</option>
                                <option value="month">This Month</option>
                                <option value="year">This Year</option>
                                <option value="custom">Custom Range</option>
                            </select>

                            <!-- Optional arrow icon (dropdown caret) -->
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path d="M5.516 7.548L10 12.032l4.484-4.484L16 8.548l-6 6-6-6z" />
                                </svg>
                            </div>

                            <!-- Custom Date Range Picker -->
                            <div id="customRange" class="mt-4 hidden space-y-2 border">
                                <input type="date" id="startDate" class="w-full rounded border-gray-300 px-4 py-2" />
                                <input type="date" id="endDate" class="w-full rounded border-gray-300 px-4 py-2" />
                            </div>
                        </div>
                    </div>

                    <script>
                        const selector = document.getElementById('periodSelector');
                        const customRange = document.getElementById('customRange');

                        selector.addEventListener('change', () => {
                            if (selector.value === 'custom') {
                            customRange.classList.remove('hidden');
                            } else {
                            customRange.classList.add('hidden');
                            }
                        });
                    </script>

                </div>
                <div id="chart"></div>
            </div>

            <script>
                var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Sales',
                    data: [30, 40, 35, 50, 49, 60, 70, 91]
                },{
                    name: 'data',
                    data: [70, 40, 45, 20, 91, 60, 50, 50]
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
                },
                stroke: {
                    curve: 'smooth'
                }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            </script>
        </div>

        <div class="bg-white rounded-lg shadow-md">
            <div class="px-4 py-5 border-b border-gray-200">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Recent Activity
                </h3>
            </div>
        
            <div class="divide-y divide-gray-200">
                <?php foreach($activities as $activity) : ?>
                <div class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 rounded-lg">
                            <i class="w-5 h-5" data-lucide="<?php echo htmlspecialchars($activity['icon'])?>"></i>
                        </div>
                        <div>
                        <p class="text-sm font-medium text-gray-900">
                            <?= $activity["description"] ?>
                        </p>
                        <p class="text-sm text-gray-500">
                            <?= $activity["timestamp"] ?>
                        </p>
                        </div>
                    </div>
                    </div>
                </div>
                <?php endforeach ; ?>
            </div>
        </div>
    </div>

    <div style="" class="mx-auto shadow-lg rounded-lg bg-white p-10 mt-20">
        <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold mt-2">Best Selling Product</h2>
            <div class="flex gap-2">
                <input type="text" placeholder="Search by name..." class="border w-full rounded-md py-2 px-4 w-1/3 outline-none" />
                <select class="border rounded-md py-2 px-4" >
                    <option value="">All Categories</option>
                    <option value="category1">Category 1</option>
                    <option value="category2">Category 2</option>
                </select>
            </div>
        </div>

        <div style="max-height: 400px" class='py-5 overflow-auto'>
            <table>
                <thead class="text-gray-500 border-b text-sm font-normal border-gray-200 hover:bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left whitespace-nowrap"></th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">PRODUCT</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">CATEGORY</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">BRAND</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">PRICE</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">STOCK</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">RATING</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">ORDER</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">SALES</th>
                        <th class="py-3 px-6 text-left whitespace-nowrap">ACTION</th>
                        
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="flex flex-col md:flex-row items-center justify-end gap-10 mt-4 space-y-2 md:space-y-0">
            <!-- Page Info -->
            <div class="text-xs text-gray-800">
                Showing page <span class="font-medium">1</span> of <span class="font-medium">1<span>
            </div>
            <!-- Pagination Buttons -->
            <div class="flex justify-end mt-4 space-x-1 text-xs">
                <a href="" class="px-3 py-2 border rounded-l bg-gray-500 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-left"></i></a>
                <a href="" class="px-3 py-2 border bg-gray-800 text-white">1</a>
                <!-- <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">2</a>
                <a href="" class="px-3 py-2 border bg-white text-gray-600 hover:bg-gray-100">3</a> -->
                <a href="" class="px-3 py-2 border rounded-r bg-gray-500 text-white"><i class="w-5 h-5 text-white" data-lucide="chevron-right"></i></a>
            </div>
        </div>
    </div>

    <div class="flex gap-10 mt-20">
        <div style="width: 500px;" class="shadow-lg rounded-lg bg-white p-5">
            <div class="flex justify-between mb-4">
                <h2 class="text-lg font-semibold mt-2">Popular Client</h2>
            </div>

            <div style="max-height: 400px" class='py-5 overflow-auto'>
                <table>
                    <thead class="text-gray-500 border-b text-sm font-normal border-gray-200 hover:bg-gray-50">
                        <tr>
                            <th class="py-3 px-6 text-left whitespace-nowrap"></th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">CLIENT NAME</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">ORDER</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">AMOUNT</th>
                            <th class="py-3 px-6 text-left whitespace-nowrap">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div>
            <div class="bg-white p-5 rounded-lg shadow-lg">
                <div class="pb-10">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-lg font-semibold mt-2">Order Overview</h2>
                    </div>

                    <div class="flex justify-between">
                        <div class="relative inline-block w-32 text-sm">
                        <select id="periodSelector" class="w-full appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="7days">Last 7 Days</option>
                            <option value="month">This Month</option>
                            <option value="year">This Year</option>
                            <option value="custom">Custom Range</option>
                        </select>

                        <!-- Optional arrow icon (dropdown caret) -->
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                            <svg class="fill-current h-4 w-4" viewBox="0 0 20 20">
                            <path d="M5.516 7.548L10 12.032l4.484-4.484L16 8.548l-6 6-6-6z" />
                            </svg>
                        </div>

                        <!-- Custom Date Range Picker -->
                        <div id="customRange" class="mt-4 hidden space-y-2 border">
                            <input type="date" id="startDate" class="w-full rounded border-gray-300 px-4 py-2" />
                            <input type="date" id="endDate" class="w-full rounded border-gray-300 px-4 py-2" />
                        </div>
                        </div>
                        <div class="text-2xl font-semibold">
                            <p>1,270</p>
                        </div>
                    </div>

                    <script>
                        const selector = document.getElementById('periodSelector');
                        const customRange = document.getElementById('customRange');

                        selector.addEventListener('change', () => {
                            if (selector.value === 'custom') {
                            customRange.classList.remove('hidden');
                            } else {
                            customRange.classList.add('hidden');
                            }
                        });
                    </script>

                </div>

                <div id="orderChart"></div>
            </div>

            <script>
                var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                    name: 'Sales',
                    data: [30, 40, 35, 50, 49, 60, 70, 91]
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug']
                },
                stroke: {
                    curve: 'smooth'
                }
                };

                var chart = new ApexCharts(document.querySelector("#orderChart"), options);
                chart.render();
            </script>
        </div>
    </div>
</div>
                   