<form id="delete-photo-form" method="POST" action="{{ route('profile.photo.destroy', ['locale' => app()->getLocale()]) }}" class="hidden">
    @csrf
    @method('DELETE')
</form>
