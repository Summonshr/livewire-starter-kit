<div id="flux-toast-container" class="fixed z-50 bottom-4 right-4 flex flex-col gap-2"></div>

<template id="flux-toast-template">
    <div class="flux-toast p-4 rounded-md shadow-lg flex items-center gap-3 transform transition-all duration-300 ease-out opacity-0 translate-x-4 max-w-xs">
        <div class="icon-container flex-shrink-0"></div>
        <div class="message-container font-medium text-sm text-zinc-800 dark:text-white"></div>
        <button class="ml-auto -mx-1.5 -my-1.5 rounded-lg focus:ring-2 p-1.5 inline-flex h-8 w-8 hover:bg-opacity-10 hover:bg-gray-500">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>
</template>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.notify = function(message, type = 'info', duration = 3000) {
            const container = document.getElementById('flux-toast-container');
            const template = document.getElementById('flux-toast-template');
            const toast = template.content.firstElementChild.cloneNode(true);
            const iconContainer = toast.querySelector('.icon-container');
            const messageContainer = toast.querySelector('.message-container');
            const closeButton = toast.querySelector('button');

            let typeClasses = '';
            let iconSvg = '';

            switch (type) {
                default:
                    typeClasses = 'max-w-sm p-2 rounded-xl shadow-lg bg-white border border-zinc-200 border-b-zinc-300/80 dark:bg-zinc-700 dark:border-zinc-600';
                    iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="block shrink-0 mt-0.5 size-4 text-lime-600 dark:text-lime-400"><path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd"></path></svg>';
                    break;
            }

            toast.classList.add(...typeClasses.split(' '));
            iconContainer.innerHTML = iconSvg;
            messageContainer.textContent = message;

            closeButton.addEventListener('click', () => removeToast(toast));

            container.appendChild(toast);
            setTimeout(() => toast.classList.remove('opacity-0', 'translate-x-4'), 10);

            const timeoutId = setTimeout(() => removeToast(toast), duration);
            toast._timeoutId = timeoutId;

            function removeToast(toastElement) {
                if (toastElement._timeoutId) {
                    clearTimeout(toastElement._timeoutId);
                }
                toastElement.classList.add('opacity-0', 'translate-x-4');
                setTimeout(() => container.removeChild(toastElement), 300);
            }
        };
    });
</script>
