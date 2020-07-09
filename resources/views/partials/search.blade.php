<form action="{{ route('search') }}" method="GET" class="search-form">
    <i class="fa fa-search search-icon"></i>
    <input class="search-box" type="text" name="query" id="query" value="{{ request()->input('query') }}"
        placeholder="Search for product" required>
</form>
