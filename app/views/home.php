<?php

    // Dummy products array
    $products = [
        [
        "id" => 1,
        "name" => "Wireless Bluetooth Headphones",
        "price" => 59.99,
        "image" => "https://via.placeholder.com/300x200?text=Headphones",
        "rating" => 4.5
        ],
        [
        "id" => 2,
        "name" => "Smart Watch Series 7",
        "price" => 129.99,
        "image" => "https://via.placeholder.com/300x200?text=Smart+Watch",
        "rating" => 4.7
        ],
        [
        "id" => 3,
        "name" => "Laptop Backpack",
        "price" => 39.95,
        "image" => "https://via.placeholder.com/300x200?text=Backpack",
        "rating" => 4.3
        ],
        [
        "id" => 4,
        "name" => "4K Action Camera",
        "price" => 89.00,
        "image" => "https://via.placeholder.com/300x200?text=Camera",
        "rating" => 4.6
        ],
        [
        "id" => 5,
        "name" => "Portable Bluetooth Speaker",
        "price" => 25.50,
        "image" => "https://via.placeholder.com/300x200?text=Speaker",
        "rating" => 4.1
        ],
        [
        "id" => 6,
        "name" => "Gaming Mouse RGB",
        "price" => 19.99,
        "image" => "https://via.placeholder.com/300x200?text=Mouse",
        "rating" => 4.4
        ],
        [
        "id" => 7,
        "name" => "Wireless Charger Stand",
        "price" => 34.99,
        "image" => "https://via.placeholder.com/300x200?text=Wireless+Charger",
        "rating" => 4.2
        ],
        [
        "id" => 8,
        "name" => "Noise Cancelling Earbuds",
        "price" => 79.99,
        "image" => "https://via.placeholder.com/300x200?text=Earbuds",
        "rating" => 4.8
        ],
    ];

    // Function to print star ratings with half stars and empty stars
    function renderStars($rating) {
        $fullStars = floor($rating);
        $halfStar = ($rating - $fullStars) >= 0.5;
        $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);

        $starsHtml = '<span class="text-yellow-400" aria-label="Rating: ' . $rating . ' out of 5 stars">';
        for ($i = 0; $i < $fullStars; $i++) {
            $starsHtml .= "&#9733;"; // solid star ★
        }
        if ($halfStar) {
            $starsHtml .= "&#189;"; // half star approx (½)
        }
        for ($i = 0; $i < $emptyStars; $i++) {
            $starsHtml .= "&#9734;"; // empty star ☆
        }
        $starsHtml .= "</span>";
        return $starsHtml;
    }
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PBUY - Products</title>
  <link rel="stylesheet" href="../public/css/style.css">
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <style>
    /* For multiline truncation */
    .line-clamp-2 {
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;  
      overflow: hidden;
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-900 flex flex-col min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow p-4 flex flex-col md:flex-row items-center justify-between sticky top-0 z-50">
    <div class="flex items-center space-x-4 mb-4 md:mb-0">
      <div class="text-3xl font-bold text-blue-600 select-none cursor-pointer">PBUY</div>
      <form class="flex" action="" method="GET">
        <input
          type="text"
          name="search"
          placeholder="Search for products..."
          class="border rounded-l px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-blue-600"
          value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
        />
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 rounded-r hover:bg-blue-700 transition"
          aria-label="Search"
        >Search</button>
      </form>
    </div>
    <div class="flex items-center space-x-5 text-gray-700">
      <!-- login button -->
      <div class="relative space-x-4 group">
          <div class="flex items-center space-x-2">
              <img
                src="https://ui-avatars.com/api/?name=guest"
                alt="guest"
                class="w-8 h-8 rounded-full"
              />
              <div class="text-sm flex gap-2">
                <p class="font-medium text-gray-700">Welcome!</p>
                <i class="h-4 w-4 mt-1" data-lucide="chevron-down"></i>
              </div>
          </div>

          <div class="absolute z-50 left-0 p-1 space-y-2 shadow-lg bg-gray-100 rounded-lg border w-full text-center font-bold text-xl opacity-0 group-hover:opacity-100 hover:opacity-100">
              <div class="font-normal text-sm gap-5 text-center w-full">
                <a href="auth/login" class="flex gap-2 px-4 py-1 rounded-lg text-black w-full h-8 hover:bg-blue-800 hover:text-white" type="submit">Login</a>
              </div>
              <div class="font-normal text-sm gap-5 text-center w-full">
                <a href="auth/signup" class="flex gap-2 px-4 py-1 rounded-lg text-black w-full h-8 hover:bg-blue-800 hover:text-white" type="submit">Signup</a>
              </div>
          </div>
      </div>

      <!-- cart -->
      <div class="pt-1 pr-10">
        <button>
          <i class="w-6 h-6" data-lucide="shopping-bag"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Hero Banner -->
  <section class="bg-blue-600 text-white p-12 rounded-b-lg mb-8 w-full h-64 mx-auto">
    <h1 class="text-4xl font-extrabold mb-2">Welcome to PBUY</h1>
    <p class="text-lg max-w-xl">Find the best deals on electronics, accessories, and more. Quality products, amazing prices.</p>
  </section>

  <!-- Main Content with Sidebar and Products -->
  <main class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row gap-8 flex-grow">

    <!-- Filters Sidebar -->
    <aside class="w-full md:w-64 bg-white rounded-lg shadow p-6 sticky top-28 h-fit self-start">
      <h3 class="text-xl font-semibold mb-4">Filters</h3>

      <!-- Categories -->
      <div class="mb-6">
        <h4 class="font-semibold mb-2">Category</h4>
        <ul class="space-y-1 text-gray-700">
          <li><label class="inline-flex items-center"><input type="checkbox" class="form-checkbox" /> <span class="ml-2">Electronics</span></label></li>
          <li><label class="inline-flex items-center"><input type="checkbox" class="form-checkbox" /> <span class="ml-2">Accessories</span></label></li>
          <li><label class="inline-flex items-center"><input type="checkbox" class="form-checkbox" /> <span class="ml-2">Backpacks</span></label></li>
          <li><label class="inline-flex items-center"><input type="checkbox" class="form-checkbox" /> <span class="ml-2">Cameras</span></label></li>
        </ul>
      </div>

      <!-- Price Range -->
      <div class="mb-6">
        <h4 class="font-semibold mb-2">Price Range</h4>
        <input type="range" min="0" max="200" value="100" class="w-full" />
        <div class="flex justify-between text-sm text-gray-600 mt-1">
          <span>$0</span>
          <span>$200+</span>
        </div>
      </div>

      <!-- Ratings -->
      <div>
        <h4 class="font-semibold mb-2">Minimum Rating</h4>
        <select class="w-full border rounded px-2 py-1">
          <option value="0">All Ratings</option>
          <option value="4">4 stars & up</option>
          <option value="3">3 stars & up</option>
          <option value="2">2 stars & up</option>
          <option value="1">1 star & up</option>
        </select>
      </div>
    </aside>

    <!-- Products Grid -->
    <section class="flex-1">
      <h2 class="text-3xl font-bold mb-6">Featured Products</h2>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-10">

        <?php foreach ($products as $product): ?>
          <article class="bg-white rounded-lg shadow hover:shadow-lg transition p-4 flex flex-col" tabindex="0">
            <img
              src="<?= htmlspecialchars($product['image']) ?>"
              alt="<?= htmlspecialchars($product['name']) ?>"
              class="w-full h-48 object-cover rounded mb-4"
              loading="lazy"
            />
            <h3 class="text-lg font-semibold mb-1 line-clamp-2"><?= htmlspecialchars($product['name']) ?></h3>
            <div class="mb-2"><?= renderStars($product['rating']) ?></div>
            <p class="text-blue-600 font-bold text-xl mb-4">$<?= number_format($product['price'], 2) ?></p>
            <button
              class="mt-auto bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
              aria-label="Add <?= htmlspecialchars($product['name']) ?> to cart"
            >Add to Cart</button>
          </article>
        <?php endforeach; ?>

      </div>

      <!-- Pagination (dummy) -->
      <nav aria-label="Page navigation" class="flex justify-center space-x-2 mb-16">
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">Prev</a>
        <a href="#" class="px-4 py-2 bg-blue-600 text-white rounded shadow">1</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">2</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">3</a>
        <a href="#" class="px-4 py-2 bg-white rounded shadow hover:bg-blue-50">Next</a>
      </nav>
    </section>

  </main>

  <!-- Footer -->
  <footer class="py-10 bg-blue-600 text-white sm:pt-16 lg:pt-24">
    <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
        <div class="grid grid-cols-2 md:col-span-3 lg:grid-cols-6 gap-y-16 gap-x-12">
            <div class="col-span-2 md:col-span-3 lg:col-span-2 lg:pr-8">
                <h2 class="text-3xl font-bold">PBUY</h2>

                <p class="text-base leading-relaxed text-white mt-7">At Joycee, we are dedicated to bringing you the best in plantain chips. Our commitment to quality, flavor, and customer satisfaction sets us apart. We believe that snacks should not only taste great but also bring a smile to your face. That’s why every bag of Joycee Plantain Chips is packed with love, care, and a whole lot of joy.</p>

                <ul class="flex items-center space-x-3 mt-9">
                    <li>
                        <a href="#" title="" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-goldenrod focus:bg-goldenrod">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M19.633 7.997c.013.175.013.349.013.523 0 5.325-4.053 11.461-11.46 11.461-2.282 0-4.402-.661-6.186-1.809.324.037.636.05.973.05a8.07 8.07 0 0 0 5.001-1.721 4.036 4.036 0 0 1-3.767-2.793c.249.037.499.062.761.062.361 0 .724-.05 1.061-.137a4.027 4.027 0 0 1-3.23-3.953v-.05c.537.299 1.16.486 1.82.511a4.022 4.022 0 0 1-1.796-3.354c0-.748.199-1.434.548-2.032a11.457 11.457 0 0 0 8.306 4.215c-.062-.3-.1-.611-.1-.923a4.026 4.026 0 0 1 4.028-4.028c1.16 0 2.207.486 2.943 1.272a7.957 7.957 0 0 0 2.556-.973 4.02 4.02 0 0 1-1.771 2.22 8.073 8.073 0 0 0 2.319-.624 8.645 8.645 0 0 1-2.019 2.083z"
                                ></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-goldenrod focus:bg-goldenrod">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M13.397 20.997v-8.196h2.765l.411-3.209h-3.176V7.548c0-.926.258-1.56 1.587-1.56h1.684V3.127A22.336 22.336 0 0 0 14.201 3c-2.444 0-4.122 1.492-4.122 4.231v2.355H7.332v3.209h2.753v8.202h3.312z"></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-goldenrod focus:bg-goldenrod">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M11.999 7.377a4.623 4.623 0 1 0 0 9.248 4.623 4.623 0 0 0 0-9.248zm0 7.627a3.004 3.004 0 1 1 0-6.008 3.004 3.004 0 0 1 0 6.008z"></path>
                                <circle cx="16.806" cy="7.207" r="1.078"></circle>
                                <path
                                    d="M20.533 6.111A4.605 4.605 0 0 0 17.9 3.479a6.606 6.606 0 0 0-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 0 0-2.184.42 4.6 4.6 0 0 0-2.633 2.632 6.585 6.585 0 0 0-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 0 0 2.634 2.632 6.584 6.584 0 0 0 2.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 0 0 2.186-.419 4.613 4.613 0 0 0 2.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 0 0-.421-2.217zm-1.218 9.532a5.043 5.043 0 0 1-.311 1.688 2.987 2.987 0 0 1-1.712 1.711 4.985 4.985 0 0 1-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 0 1-1.669-.311 2.985 2.985 0 0 1-1.719-1.711 5.08 5.08 0 0 1-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 0 1 .311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 0 1 1.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 0 1 1.67.311 2.991 2.991 0 0 1 1.712 1.712 5.08 5.08 0 0 1 .311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z"
                                ></path>
                            </svg>
                        </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex items-center justify-center text-white transition-all duration-200 bg-gray-800 rounded-full w-7 h-7 hover:bg-goldenrod focus:bg-goldenrod">
                            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    fillRule="evenodd"
                                    clipRule="evenodd"
                                    d="M12.026 2c-5.509 0-9.974 4.465-9.974 9.974 0 4.406 2.857 8.145 6.821 9.465.499.09.679-.217.679-.481 0-.237-.008-.865-.011-1.696-2.775.602-3.361-1.338-3.361-1.338-.452-1.152-1.107-1.459-1.107-1.459-.905-.619.069-.605.069-.605 1.002.07 1.527 1.028 1.527 1.028.89 1.524 2.336 1.084 2.902.829.091-.645.351-1.085.635-1.334-2.214-.251-4.542-1.107-4.542-4.93 0-1.087.389-1.979 1.024-2.675-.101-.253-.446-1.268.099-2.64 0 0 .837-.269 2.742 1.021a9.582 9.582 0 0 1 2.496-.336 9.554 9.554 0 0 1 2.496.336c1.906-1.291 2.742-1.021 2.742-1.021.545 1.372.203 2.387.099 2.64.64.696 1.024 1.587 1.024 2.675 0 3.833-2.33 4.675-4.552 4.922.355.308.675.916.675 1.846 0 1.334-.012 2.41-.012 2.737 0 .267.178.577.687.479C19.146 20.115 22 16.379 22 11.974 22 6.465 17.535 2 12.026 2z"
                                ></path>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Company</p>

                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> About </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Features </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Works </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Career </a>
                    </li>
                </ul>
            </div>

            <div>
                <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Help</p>

                <ul class="mt-6 space-y-4">
                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Customer Support </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Delivery Details </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Terms & Conditions </a>
                    </li>

                    <li>
                        <a href="#" title="" class="flex text-base text-white transition-all duration-200 hover:text-goldenrod focus:text-goldenrod"> Privacy Policy </a>
                    </li>
                </ul>
            </div>

            <div class="col-span-2 md:col-span-1 lg:col-span-2 lg:pl-8">
                <p class="text-sm font-semibold tracking-widest text-gray-400 uppercase">Subscribe to newsletter</p>

                <form action="#" method="POST" class="mt-6">
                    <div>
                        <label htmlFor="email" class="sr-only">Email</label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="block w-full p-4 text-white placeholder-gray-500 transition-all duration-200 bg-white border border-gray-200 rounded-md focus:outline-none focus:border-blue-600 caret-blue-600" />
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center px-6 py-4 mt-3 font-semibold text-white transition-all duration-200 bg-black rounded-md hover:scale-105 focus:bg-goldenrod">Subscribe</button>
                </form>
            </div>
        </div>

        <hr class="mt-16 mb-10 border-gray-200" />
 
        <p class="text-sm text-center text-gray-400">© Copyright 2024, All Rights Reserved by JoshTheBaddest</p>
    </div>
  </footer>

  <script>
      lucide.createIcons();
  </script>
</body>
</html>
