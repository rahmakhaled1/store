
        <div class="form-group">

           <x-form.input label="Product Name" class="form-control" name="name" value="{{$product->name}}"/>
        </div>
        <div class="form-group">
            <label for="">Category </label>
            <select name="category_id" class="form-control form-select">
                <option value="">Primary Category</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{$category->id}}" @selected(old('category_id',$product->category_id) ==$category->id)>{{$category->name}}</option>
                @endforeach
            </select>

        </div>
        <div class="form-group">
            <label for="">Description</label>
            <x-form.textarea  name="description" value="{{$product->description}}"/>
        </div>
        @error('description')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
        <div class="form-group">
            <x-form.label id="image">Image</x-form.label>
            <x-form.input type="file" name="image" accept="image/*"/>
            @if($product->image)
                <img src="{{asset('storage/'.$product->image)}}" height="100px">
            @endif
        </div>
        @error('image')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
        <div class="form-group">
            <x-form.label >Status</x-form.label>
            <div>
                <x-form.radio name="status" :checked="$category->status" :options="['draft'=>'Draft','active'=>'Active','archive'=>'Archive']"/>
            </div>
        </div>
        @error('status')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
        <div class="form-group">

            <x-form.input label="Price" class="form-control" name="price" value="{{$product->price}}"/>
        </div>

        <div class="form-group">
            <x-form.input label="Compare Price" class="form-control" name="compare_price" value="{{$product->compare_price}}"/>
        </div>

        <div class="form-group">
            <x-form.input label="Tags" class="form-control" name="tags" :value="$tags"/>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label ?? 'Save'}}</button>
        </div>

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify (inputElm);
    </script>
@endpush
