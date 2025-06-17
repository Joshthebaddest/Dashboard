<?php 
    $resendStatus = null;
?>

<div class="w-full h-screen p-8">
    <div class="flex flex-col items-center space-y-6 my-auto mx-auto">
        <!-- Lock Icon -->
        <div class="bg-indigo-600 p-4 rounded-full shadow-lg">
            <i data-lucide="lock" class="lucide-icon w-10 h-10 text-white"></i>
        </div>

        <!-- Heading -->
        <h1 class="text-3xl font-extrabold text-indigo-600 tracking-wide">Verify Your Email</h1>

        <!-- Info text -->
        <p class="text-black text-center">
            We’ve sent a verification link to your email. Please check your inbox and click the link to activate your account.
        </p>

        <!-- Status message -->
        <?php if ($resendStatus): ?>
            <div class="bg-indigo-700 text-indigo-100 rounded-md px-4 py-2 text-center w-full">
                <?= htmlspecialchars($resendStatus) ?>
            </div>
        <?php endif; ?>

        <!-- Resend button form -->
        <form method="POST" class="w-full flex justify-center">
            <button
                type="submit"
                name="resend"
                class="inline-flex items-center space-x-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 transition-colors rounded-lg px-6 py-3 font-semibold text-white shadow-md focus:outline-none focus:ring-4 focus:ring-indigo-500"
            >
                <i data-lucide="refresh-ccw" class="lucide-icon w-5 h-5 stroke-white"></i>
                <span>Resend Email</span>
            </button>
        </form>
    </div>
</div>