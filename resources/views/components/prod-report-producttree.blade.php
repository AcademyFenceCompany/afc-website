<nav aria-label="breadcrumb" class="bg-light d-print-none p-3">
  <ol class="breadcrumb mt-2 float-start">
    <li class="breadcrumb-item text-primary"><strong>{{ $categoryqry->firstWhere('id', $id)->maj_cat_name ?? 'N/A' }}</strong></li>
    <li class="breadcrumb-item text-primary"><strong>{{ $categoryqry->firstWhere('id', $id)->cat_name ?? 'N/A' }}</strong> ({{$id}})</li>
    @if(!empty($filters['size']['selected']))
        <li class="breadcrumb-item text-primary">{{ $filters['size']['selected'] }}</li>
    @endif
    @if(!empty($filters['size2']['selected']))
        <li class="breadcrumb-item text-primary">{{ $filters['size2']['selected'] }}</li>
    @endif
    @if(!empty($filters['size3']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['size3']['selected'] }}</li>
    @endif
    @if(!empty($filters['style']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['style']['selected'] }}</li>
    @endif
    @if(!empty($filters['speciality']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['speciality']['selected'] }}</li>
    @endif
    @if(!empty($filters['spacing']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['spacing']['selected'] }}</li>
    @endif
    @if(!empty($filters['material']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['material']['selected'] }}</li>
    @endif
    @if(!empty($filters['coating']['selected']))
        <li class="breadcrumb-item text-primary" aria-current="page">{{ $filters['coating']['selected'] }}</li>
    @endif
    @if(!empty($filters['color']['selected']))
        <li class="breadcrumb-item active" aria-current="page">{{ $filters['color']['selected'] }}</li>
    @endif
  </ol>
  <span class="badge bg-success text-light rounded-pill p-3 ms-3">{{ count($products) }} Records</span></p>
</nav>
