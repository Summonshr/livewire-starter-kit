<ui-notify x-data="{}" x-on:notify.document="$el.notify($event.detail)" wire:ignore role="toast">
    <template>
        <div popover="manual" class="m-0 p-6 bg-transparent [&[data-position*=top]]:mb-auto [&[data-position*=bottom]]:mt-auto [&[data-position*=right]]:ml-auto [&[data-position*=left]]:mr-auto pt-24" data-position="bottom right" data-variant="" data-flux-toast-dialog="">
            <div class="max-w-sm p-2 rounded-xl shadow-lg bg-white border border-zinc-200 border-b-zinc-300/80 dark:bg-zinc-700 dark:border-zinc-600">
                <div class="flex items-start gap-4">
                    <div class="flex-1 py-1.5 pl-2.5 flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=success]_&]:block shrink-0 mt-0.5 size-4 text-lime-600 dark:text-lime-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=warning]_&]:block shrink-0 mt-0.5 size-4 text-amber-500 dark:text-amber-400">
                            <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=danger]_&]:block shrink-0 mt-0.5 size-4 text-rose-500 dark:text-rose-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="hidden [[data-flux-toast-dialog][data-variant=info]_&]:block shrink-0 mt-0.5 size-4 text-zinc-500 dark:text-zinc-400">
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
                        </svg>

                        <div>
                            <div class="font-medium text-sm text-zinc-800 dark:text-white [&:not(:empty)+div]:font-normal [&:not(:empty)+div]:text-zinc-500 [&:not(:empty)+div]:dark:text-zinc-300 [&:not(:empty)]:pb-2">
                                <slot name="heading"></slot>
                            </div>
                            <div class="font-medium text-sm text-zinc-800 dark:text-white">
                                <slot name="text"></slot>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <button type="button" onclick="this.closest('ui-notify').hideToast()" class="inline-flex items-center font-medium justify-center gap-2 truncate disabled:opacity-50 dark:disabled:opacity-75 disabled:cursor-default h-8 text-sm rounded-md w-8 bg-transparent hover:bg-zinc-800/5 dark:hover:bg-white/15 text-zinc-400 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
                            <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</ui-notify>


<script>
    class Toast extends HTMLElement {
        connectedCallback() {
            this.setAttribute("role", "status");
            document.addEventListener("keydown", (e) => e.key === "Escape" && this.hideToast());
        }

        notify({
            duration = 5000,
            slots = {},
            dataset = {}
        } = {}) {
            this.hideToast();
            let template = this.querySelector("template")?.content.firstElementChild;
            let toast = template.cloneNode(true);
            toast.setAttribute("aria-atomic", "true");

            Object.entries(slots).forEach(([name, content]) => {
                if (content) {
                    toast.querySelector(`slot[name="${name}"]`)?.replaceWith(content)
                } else {
                    toast.querySelector(`slot[name="${name}"]`)?.parentElement?.remove();
                }
            });

            Object.assign(toast.dataset, dataset);
            toast.querySelectorAll("slot").forEach((slot) => slot.remove());

            this.appendChild(toast);
            toast.showPopover();

            let timeout = duration && setTimeout(() => toast.remove(), duration);
            toast.destroyToast = () => {
                clearTimeout(timeout);
                toast.remove();
            };
        }

        hideToast() {
            this.querySelector(":scope > div")?.destroyToast();
        }
    }

    customElements.define("ui-notify", Toast);
</script>
