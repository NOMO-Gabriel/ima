<?php if(Session::has('status')): ?>
    <div id="flash-message" class="mb-6 <?php echo e(Session::get('status-type') === 'success' ? 'bg-[#34D399]/10 border-[#34D399]' : 'bg-[#F87171]/10 border-[#F87171]'); ?> text-[#1E293B] rounded-lg p-4 flex items-start">
        <div class="flex-shrink-0 mr-3">
            <?php if(Session::get('status-type') === 'success'): ?>
                <svg class="h-5 w-5 text-[#34D399]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            <?php else: ?>
                <svg class="h-5 w-5 text-[#F87171]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            <?php endif; ?>
        </div>
        <div>
            <p class="font-medium"><?php echo e(Session::get('status-type') === 'success' ? 'Succès!' : 'Information'); ?></p>
            <p class="text-sm"><?php echo e(Session::get('status')); ?></p>
        </div>
        <button type="button" class="ml-auto" onclick="this.parentElement.remove()">
            <svg class="h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <script>
        // Faire disparaître automatiquement la notification après 5 secondes
        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.transition = 'opacity 0.5s ease-out';
                flashMessage.style.opacity = '0';
                setTimeout(() => {
                    flashMessage.remove();
                }, 500);
            }
        }, 5000);
    </script>
<?php endif; ?>
<?php /**PATH /home/gabriel/Documents/projects/bussiness/ima-icorp/code-ima-icorp/prod/ima/resources/views/components/flash-message.blade.php ENDPATH**/ ?>