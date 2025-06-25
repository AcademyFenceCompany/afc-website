
<div class="card filter-box mb-3">
    <div class="card-body">
        <h5 class="card-title">Filter By {{$filtername}} ({{$colname}})</h5>
        @foreach($filters as $key => $filter)
            @if(!empty($filter))
            <div class="form-check form-check-inline {{ $filter == $selected ? 'bg-secondary text-light' : '' }}">
                <input class="form-check-input input-filter" type="checkbox" name="{{$inputname}}[]" value="{{$filter}}" id="checkDefault_{{$inputname}}_{{$key}}" {{ $filter == $selected ? 'checked' : '' }}>
                <label class="form-check-label" for="checkDefault_{{$inputname}}_{{$key}}">
                {{ $filter }}
                </label>
            </div>
            @endif
        @endforeach
    </div>
</div>