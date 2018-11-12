@foreach($categories as $category)
    <option value="{{$category->id}}">{{$split.$category->title}}</option>
    @if($category->child)
        @include('admin/products/categories', ['categories' => $category->child, 'split' => '-'.$split]) 
    @endif
@endforeach