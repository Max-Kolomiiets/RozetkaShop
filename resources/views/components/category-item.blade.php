{{-- ({{ $category->id }}) --}}
{{ $category->name }}

<ul id="link">
    @foreach ($category->children as $child)
        <li class="category_li">
            <a class="category_li" style="color: #4d4b4b;" href="
            {{ route('category.show', $child->id) }}">
                >

                <x-category-item :category="$child" />
            </a>

        </li>
    @endforeach
</ul>
