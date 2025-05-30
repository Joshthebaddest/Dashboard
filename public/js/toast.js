function showToast(message, type = 'info', duration = 4000) {
    const toast = document.createElement('div');
    const bgColors = {
        success: 'bg-green-800',
        error: 'bg-red-800',
        info: 'bg-blue-800'
    };

    toast.className = `
        relative flex flex-col text-white text-sm font-medium px-4 py-3 rounded shadow-lg transition transform duration-300 ease-in-out
        ${bgColors[type] || bgColors.info}
        animate-slide-in
    `;

    toast.innerHTML = `
        <div class="flex justify-between items-center">
          <span>${message}</span>
          <button class="ml-4 text-white" onclick="this.closest('.toast').remove()">✖</button>
        </div>
        <div class="absolute top-0 left-0 h-1 bg-white w-full progress-bar rounded-b"></div>
    `;

    toast.classList.add("toast");

    document.getElementById('toast-container').appendChild(toast);

    // Auto-remove
    setTimeout(() => {
        toast.classList.remove('animate-slide-in');
        toast.classList.add('animate-slide-out');
        setTimeout(() => toast.remove(), 300);
    }, duration);
}