<div>
    {{ $category->name }} ({{ $category->id }})
 
    @foreach ($category->children as $child)
        <div style="margin-left: 20px;">
            <x-category-item :category="$child" />
        </div>
    @endforeach
</div>