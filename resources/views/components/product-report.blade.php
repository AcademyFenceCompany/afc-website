@if(!empty($filters))
    <x-prod-report-producttree :filters="$filters" :products="$products" :id="$id" :categoryqry="$categoryqry" />
@endif
<p>Use the filters below to narrow down your search.</p>
<form id="product-report-form-filter" class="d-print-none" method="POST" action="{{ route('ams.product-report.filter') }}" onchange="App.getFilter(this)">
    @if(!empty($filters['size']))
        <x-prod-report-filter-list :filters="$filters['size']['size']" :selected="$filters['size']['selected']" :filtername="$columnHeaders['size']" :colname="'size1'" :inputname="'size'"/>
    @endif
    @if(!empty($filters['size2']))
        <x-prod-report-filter-list :filters="$filters['size2']['size2']" :selected="$filters['size2']['selected']" :filtername="$columnHeaders['size2']" :colname="'size2'"  :inputname="'size2'" />
    @endif
    @if(!empty($filters['size3']))
        <x-prod-report-filter-list :filters="$filters['size3']['size3']" :selected="$filters['size3']['selected']" :filtername="$columnHeaders['size3']" :colname="'size3'"  :inputname="'size3'" />
    @endif
    @if(!empty($filters['color']))
        <x-prod-report-filter-list :filters="$filters['color']['color']" :selected="$filters['color']['selected']" :filtername="$columnHeaders['color']" :colname="'color'"  :inputname="'color'" />
    @endif
    @if(!empty($filters['style']))
        <x-prod-report-filter-list :filters="$filters['style']['style']" :selected="$filters['style']['selected']" :filtername="$columnHeaders['style']" :colname="'style'"  :inputname="'style'" />
    @endif
    @if(!empty($filters['spacing']))
        <x-prod-report-filter-list :filters="$filters['spacing']['spacing']" :selected="$filters['spacing']['selected']" :filtername="$columnHeaders['spacing']" :colname="'spacing'"  :inputname="'spacing'" />
    @endif
    @if(!empty($filters['speciality']))
        <x-prod-report-filter-list :filters="$filters['speciality']['speciality']" :selected="$filters['speciality']['selected']" :filtername="$columnHeaders['speciality']" :colname="'specialty'"  :inputname="'speciality'" />
    @endif
    @if(!empty($filters['coating']))
        <x-prod-report-filter-list :filters="$filters['coating']['coating']" :selected="$filters['coating']['selected']" :filtername="$columnHeaders['coating']" :colname="'coating'"  :inputname="'coating'" />
    @endif
    @if(!empty($filters['material']))
        <x-prod-report-filter-list :filters="$filters['material']['material']" :selected="$filters['material']['selected']" :filtername="$columnHeaders['material']" :colname="'material'"  :inputname="'material'" />
    @endif
    <input type="hidden" name="cat_id" value="{{ $id }}">
</form>
<div class="d-none d-print-block">
    This is a print preview. Please adjust your print settings to ensure the report fits on the page.
</div>

@if(!empty($filters))
    <x-prod-report-producttree :filters="$filters" :products="$products" :id="$id" :categoryqry="$categoryqry" />
@endif

@if(!$products->isEmpty())
<div class="d-print-table">
    <table class="table table-striped" id="product-report-table">
        <thead>
            <tr class="d-print-none db-table-header" style="color:#757575;">
                <td scope="col">DB: item_no</td>
                <td>DB: product_name</td>
                <td>DB: color</td>
                <td>DB: size</td>
                <td>DB: size2</td>
                <td>DB: size3</td>
                <td>DB: style</td>
                <td>DB: coating</td>
                <td>DB: cost</td>
                <td>DB: price</td>
            </tr>
            <tr>
                <th scope="col">Item#</th>
                <th scope="col">Name</th>
                <th scope="col">Color</th>
                <th scope="col">{{$columnHeaders['size']}}</th>
                <th scope="col">{{$columnHeaders['size2']}}</th>
                <th scope="col">{{$columnHeaders['size3']}}</th>
                <th scope="col">{{$columnHeaders['style']}}</th>
                <th scope="col">{{$columnHeaders['coating']}}</th>
                <th scope="col">Cost</th>
                <th scope="col">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr data-id="{{ $product->id }}">
                <th scope="row">{{ $product->item_no }} <a class="btn btn-outline-secondary px-2 py-1" href="#" role="button" onclick="App.openModal({{$product->id}},'exampleModal')">
                    <i class="bi bi-pencil-fill"></i></a>
                </th>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->color }}</td>
                <td>{{ $product->size }}</td>
                <td>{{ $product->size2 }}</td>
                <td>{{ $product->size3 }}</td>
                <td>{{ $product->style }}</td>
                <td>{{ $product->coating }}</td>
                <td>{{ $product->cost }}</td>
                <td>{{ $product->price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@else
    <p><strong>Sorry, no records were found matching your criteria.</strong> Please adjust the filters and try again.</p>
@endif