<option value="">-- Sub Category --</option>
@foreach ($subCategories as $ob)
    <option value="{{$ob->id}}">{{$ob->cat_name}}</option>
@endforeach