
        <div class="form-group">

           <x-form.input label="Category Name" class="form-control" name="name" value="{{$category->name}}"/>
        </div>
        <div class="form-group">
            <label for="">Category Parent</label>
            <select name="parent_id" class="form-control form-select">
                <option value="">Primary Category</option>
                @foreach($parents as $parent)
                    <option value="{{$parent->id}}" @selected(old('parent_id',$category->parent_id) ==$parent->id)>{{$parent->name}}</option>
                @endforeach
            </select>
            @error('parent_id')
            <div class="text-danger">
                {{$message}}
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="">Description</label>
            <x-form.textarea  name="description" value="{{$category->description}}"/>
        </div>
        @error('description')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
        <div class="form-group">
            <x-form.label id="image">Image</x-form.label>
            <x-form.input type="file" name="image" accept="image/*"/>
            @if($category->image)
                <img src="{{asset('storage/'.$category->image)}}" height="100px">
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
               <x-form.radio name="status" :checked="$category->status" :options="['active'=>'Active','archive'=>'Archive']"/>
            </div>
        </div>
        @error('status')
        <div class="text-danger">
            {{$message}}
        </div>
        @enderror
        <div class="form-group">
            <button type="submit" class="btn btn-primary">{{$button_label ?? 'Save'}}</button>
        </div>

