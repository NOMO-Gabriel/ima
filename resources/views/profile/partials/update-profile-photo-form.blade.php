<form id="delete-photo-form" method="POST" action="{{ route('profile.photo.destroy') }}" class="hidden">
    @csrf
    @method('DELETE')
</form>