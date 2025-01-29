@extends('layouts.ams')

@section('title', 'Categories')

@section('content')

<div class="container">
    <div class="row add_product__title">
        <h2>CATEGORY MANAGEMENT</h2>
    </div>

    <!-- Top Buttons  -->

    <div class="row d-flex align-items-center justify-content-between">
        <!-- Create New Category Button (Left) -->
        <div class="col-md-4">
            <button class="btn btn-light fa-light fa-plus">
                Create New Category
            </button>
        </div>

        <!-- Right Section: Select All, Save & Delete -->
        <div class="col-md-8 d-flex align-items-center justify-content-end gap-3">
            <!-- Select All Checkbox -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    Select all
                </label>
            </div>

            <!-- Save Button -->
            <button class="btn btn-light">Save</button>

            <!-- Delete Button -->
            <button class="btn btn-light">
                <i class="fa-solid fa-trash-can"></i> Delete
            </button>
        </div>
    </div>


    <table class="table">
        <tbody>
            <tr>
                <td colspan="2">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-chevron-up"></i>
                        <span>WOOD FENCE</span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Select
                        </label>
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2 fa-light fa-plus">
                        <span>Add Sub</span>
                    </div>
                </td>

                <td><i class="fa-solid fa-arrows-up-down"></i></td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-regular fa-copy"></i><span>Copy</span>
                    </div>
                </td>

                <td>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-trash-can"></i><span>Delete</span>
                    </div>
                </td>

            </tr>

        </tbody>
    </table>


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


</div>