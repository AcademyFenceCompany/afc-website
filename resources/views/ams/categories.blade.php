@extends('layouts.ams')

@section('title', 'Categories')

@section('content')

<div class="container">
    <div class="row add_product__title">
        <h2>CATEGORY MANAGEMENT</h2>
    </div>

    <!-- Top Buttons -->
    <div class="row d-flex align-items-center justify-content-between">
        <div class="col-md-4">
            <button class="btn btn-light">
                <i class="fa-light fa-plus"></i> Create New Category
            </button>
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-end gap-2">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">Select all</label>
            </div>
            <button class="btn btn-light">Save</button>
            <button class="btn btn-light">
                <i class="fa-solid fa-trash-can"></i> Delete
            </button>
        </div>
    </div>

    <!-- Category Table -->
    <table class="table">
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td colspan="2" class="py-1">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $loop->index }}"></i>
                        <span>{{ $category->family_category_name }}</span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                </td>
                <td><input class="form-check-input" type="checkbox"></td>
                <td><button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i> Add Sub</button></td>
                <td><i class="fa-solid fa-arrows-up-down"></i></td>
                <td><button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i> Copy</button></td>
                <td><button class="btn btn-sm btn-light"><i class="fa-solid fa-trash-can"></i> Delete</button></td>
            </tr>
            <tr>
                <td colspan="7" class="py-1">
                    <div class="collapse" id="collapse-{{ $loop->index }}">
                        @if (collect($category->children)->isNotEmpty())
                            <table class="table table-sm">
                                <tbody>
                                    @foreach ($category->children as $child)
                                    <tr>
                                        <td colspan="2" class="py-1 ps-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                <span>{{ $child->family_category_name }}</span>
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </div>
                                        </td>
                                        <td><input class="form-check-input" type="checkbox"></td>
                                        <td><button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i> Add Sub</button></td>
                                        <td><i class="fa-solid fa-arrows-up-down"></i></td>
                                        <td><button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i> Copy</button></td>
                                        <td><button class="btn btn-sm btn-light"><i class="fa-solid fa-trash-can"></i> Delete</button></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7" class="py-1 ps-5">
                                            <div class="collapse" id="subcollapse-{{ $loop->parent->index }}-{{ $loop->index }}">
                                                @if (collect($child->children)->isNotEmpty())
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            @foreach ($child->children as $subChild)
                                                            <tr>
                                                                <td colspan="2" class="py-1 ps-5">
                                                                    <div class="d-flex align-items-center gap-2">
                                                                        <i class="fa-solid fa-chevron-down toggle-icon" data-bs-toggle="collapse" data-bs-target="#subsubcollapse-{{ $loop->parent->parent->index }}-{{ $loop->parent->index }}-{{ $loop->index }}"></i>
                                                                        <span>{{ $subChild->family_category_name }}</span>
                                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                                    </div>
                                                                </td>
                                                                <td><input class="form-check-input" type="checkbox"></td>
                                                                <td><button class="btn btn-sm btn-light"><i class="fa-light fa-plus"></i> Add Sub</button></td>
                                                                <td><i class="fa-solid fa-arrows-up-down"></i></td>
                                                                <td><button class="btn btn-sm btn-light"><i class="fa-regular fa-copy"></i> Copy</button></td>
                                                                <td><button class="btn btn-sm btn-light"><i class="fa-solid fa-trash-can"></i> Delete</button></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function toggleChildren(event) {
        let childrenList = event.target.nextElementSibling;
        if (childrenList) {
            childrenList.style.display = childrenList.style.display === "none" ? "block" : "none";
        }
    }
</script>





    <ul class="tree">
        @foreach ($categories as $category)
            <li class="category">
                <!-- Category with children, display the toggle button and recursive children -->
                <h3 class="toggle-btn" onclick="toggleChildren(event)">
                    {{ $category->family_category_name }}
                </h3>
                <ul class="children" style="display: none;"> <!-- Keep children hidden by default -->
                    @foreach ($category->children as $child)
                        @include('ams.tree', ['category' => $child])
                    @endforeach
                </ul>
            </li>
        @endforeach
    </ul>
    @endsection

    <script>
        // JavaScript function to toggle children visibility
        function toggleChildren(event) {
            const childrenList = event.target.nextElementSibling;
            if (childrenList) {
                childrenList.style.display = (childrenList.style.display === "none" || childrenList.style.display === "") ?
                    "block" : "none";
            }
        }
    </script>

