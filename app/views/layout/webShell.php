<?php
    require_once __DIR__ .'/../../utils/cartFunc.php';
    require_once __DIR__ . '/../../controllers/searchController.php';
    $user = isset($_SESSION['user']) ?? null;
    $cart = new CartManager($user); 
    $carts = $cart -> getCart();
    $count = count($carts);
?>

<div className="flex flex-col min-h-screen">   
  <!-- Header -->
    <div class="bg-gray-900 text-white text-sm">
        <div class="container mx-auto px-4 py-2">
            <div class="flex justify-between items-center">
            <!-- Left Side: Delivery Location -->
            <div class="flex items-center space-x-4">
                <div class="flex items-center">
                    <i data-lucide="map-pin" class="h-4 w-4 mr-1"></i>
                    <span>Deliver to Lagos 10001</span>
                </div>
            </div>

            <!-- Right Side: Links -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="/help" class="hover:text-gray-300">Customer Service</a>
                <a href="/sell" class="hover:text-gray-300">Sell on MarketPlace</a>
                <a href="/track" class="hover:text-gray-300">Track Your Order</a>
            </div>
            </div>
        </div>
    </div>
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
      <!-- <div class="relative space-x-4 group">
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
      </div> -->

      <!-- Dropdown Menu -->
        <div class="relative group hidden md:flex items-center space-x-1 cursor-pointer">
            <!-- Trigger -->
            <div class="flex items-center space-x-2">
                <i data-lucide="user" class="h-5 w-5"></i>
                <div class="text-left">
                <div class="text-xs text-gray-600">Hello, Sign in</div>
                <div class="text-sm font-medium">Account & Lists</div>
                </div>
            </div>

            <!-- Dropdown Content -->
            <div class="absolute top-10 right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-50">
                <a href="<?= BASE_PATH ?>auth/login" class="block px-4 py-2 hover:bg-gray-100">Sign In</a>
                <a href="<?= BASE_PATH ?>auth/signup" class="block px-4 py-2 hover:bg-gray-100">Create Account</a>
                <hr class="my-1 border-gray-300">
                <a href="<?= BASE_PATH ?>dashboard" class="block px-4 py-2 hover:bg-gray-100">My Account</a>
                <a href="<?= BASE_PATH ?>dashboard/orders" class="block px-4 py-2 hover:bg-gray-100">My Orders</a>
                <a href="<?= BASE_PATH ?>dashboard/recommendations" class="block px-4 py-2 hover:bg-gray-100">Wishlist</a>
            </div>
        </div>


      <!-- cart -->
        <div class="pt-1 pr-10 relative">
            <a href="<?= BASE_PATH ?>cart" class="relative">
                <i class="w-6 h-6" data-lucide="shopping-bag"></i>
                <!-- Cart item count badge -->
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                    <?= $count ?>
                </span>
            </a>
        </div>

    </div>
  </header>

    <main className="flex-1">
        <?php echo $content; ?>
    </main>

    <footer class="bg-gray-900 text-white">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- {/* Company Info */} -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <i data-lucide="store" class="h-6 w-6 text-blue-400"> </i>
                        <span class="font-bold text-xl">MultiVendor</span>
                    </div>
                    <p class="text-gray-400">Your trusted marketplace connecting buyers with quality vendors worldwide.</p>
                    <div class="flex space-x-4">
                        <i data-lucide="facebook" class="h-5 w-5 text-gray-400 hover:text-white cursor-pointer"></i>
                        <i data-lucide="twitter" class="h-5 w-5 text-gray-400 hover:text-white cursor-pointer"></i>
                        <i data-lucide="instagram" class="h-5 w-5 text-gray-400 hover:text-white cursor-pointer"></i>
                        <i data-lucide="mail" class="h-5 w-5 text-gray-400 hover:text-white cursor-pointer"></i>
                    </div>
                </div>

                <!-- {/* Quick Links */} -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/products" class="text-gray-400 hover:text-white">
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="/vendors" class="text-gray-400 hover:text-white">
                                Vendors
                            </a>
                        </li>
                        <li>
                            <a href="/categories" class="text-gray-400 hover:text-white">
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="/deals" class="text-gray-400 hover:text-white">
                                Deals
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- {/* Customer Service */} -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Customer Service</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/help" class="text-gray-400 hover:text-white">
                                Help Center
                            </a>
                        </li>
                        <li>
                            <a href="/contact" class="text-gray-400 hover:text-white">
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a href="/returns" class="text-gray-400 hover:text-white">
                                Returns
                            </a>
                        </li>
                        <li>
                            <a href="/shipping" class="text-gray-400 hover:text-white">
                                Shipping Info
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- {/* Legal */} -->
                <div>
                    <h3 class="font-semibold text-lg mb-4">Legal</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="/privacy" class="text-gray-400 hover:text-white">
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="/terms" class="text-gray-400 hover:text-white">
                                Terms of Service
                            </a>
                        </li>
                        <li>
                            <a href="/cookies" class="text-gray-400 hover:text-white">
                                Cookie Policy
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 MultiVendor. All rights reserved.</p>
            </div>
        </div>
    </footer>
</div>