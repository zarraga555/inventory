<div
    x-data="{
        show: false,
        title: '',
        message: '',
        variant: 'success',
        showToast(data) {
            if (Array.isArray(data)) {
                data = data[0]; // ← corregimos si viene como array
            }
            console.log('Data normalizada:', data);
            this.variant = data.type ?? 'success';
            this.title = data.title ?? 'Mensaje';
            this.message = data.message ?? '';
            this.show = true;
            setTimeout(() => this.show = false, 4000);
        }
        {{-- showToast(data) {
            this.variant = data.type ?? 'success';
            this.title = data.title ?? 'Mensaje';
            this.message = data.message ?? '';
            this.show = true;
            setTimeout(() => this.show = false, 4000);
        } --}}
         {{-- showToast(data) {
            console.log('Datos del toast recibidos:', data);

            alert(JSON.stringify(data)); // 👈 Esto te mostrará los datos visualmente

            this.variant = data.type ?? 'success';
            this.title = data.title ?? 'Mensaje';
            this.message = data.message ?? '';
            this.show = true;
            setTimeout(() => this.show = false, 4000);
        } --}}
    }"
    x-on:show-toast.window="showToast($event.detail)"
    x-show="show"
    x-transition
    class="fixed top-6 right-6 z-50"
    style="width: max-content"
>
    <div data-position="top right" data-variant="" data-flux-toast-dialog>
        <div class="max-w-sm p-2 rounded-xl shadow-lg bg-white border border-zinc-200 border-b-zinc-300/80 dark:bg-zinc-700 dark:border-zinc-600">
            <div class="flex items-start gap-4">
                <div class="flex-1 py-1.5 ps-2.5 flex gap-2">

                    <!-- Success icon -->
                    <svg x-show="variant === 'success'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="shrink-0 mt-0.5 size-4 text-lime-600 dark:text-lime-400">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14Zm3.844-8.791a.75.75 0 0 0-1.188-.918l-3.7 4.79-1.649-1.833a.75.75 0 1 0-1.114 1.004l2.25 2.5a.75.75 0 0 0 1.15-.043l4.25-5.5Z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Warning icon -->
                    <svg x-show="variant === 'warning'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="shrink-0 mt-0.5 size-4 text-amber-500 dark:text-amber-400">
                        <path fill-rule="evenodd" d="M6.701 2.25c.577-1 2.02-1 2.598 0l5.196 9a1.5 1.5 0 0 1-1.299 2.25H2.804a1.5 1.5 0 0 1-1.3-2.25l5.197-9ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 1 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Danger icon -->
                    <svg x-show="variant === 'danger' || variant === 'error'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="shrink-0 mt-0.5 size-4 text-rose-500 dark:text-rose-400">
                        <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14ZM8 4a.75.75 0 0 1 .75.75v3a.75.75 0 0 1-1.5 0v-3A.75.75 0 0 1 8 4Zm0 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"></path>
                    </svg>

                    <div>
                        <div class="font-medium text-sm text-zinc-800 dark:text-white pb-1" x-text="title"></div>
                        <div class="font-medium text-sm text-zinc-800 dark:text-white" x-text="message"></div>
                    </div>
                </div>

                <div class="flex items-center">
                    <button @click="show = false"
                            class="inline-flex items-center justify-center h-8 w-8 text-sm rounded-md text-zinc-400 hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800/50">
                        <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>