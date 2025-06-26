@extends('layouts.ams')

@section('content')
<div class="container-fluid p-4 my-4">
    <h4><i class="bi bi-shipping me-2 text-primary"></i>Shipping Module</h4>
    <p>Use this module to simulate shipping rates, manage package details, and apply state-specific markups for AMS orders.</p>
    <x-cart-shipping-insert-ams />
    <form id="shippingForm" action="{{ route('ams.shipping-module.process') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Ship From & Ship To -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">Ship From Address</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="ship_from_address" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address 2</label>
                                    <input type="text" class="form-control" name="ship_from_address2">
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="ship_from_city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="ship_from_state" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Zip</label>
                                            <input type="text" class="form-control" name="ship_from_zip" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">Ship To Address</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" name="ship_to_address" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address 2</label>
                                    <input type="text" class="form-control" name="ship_to_address2">
                                </div>
                            </div>
                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">City</label>
                                            <input type="text" class="form-control" name="ship_to_city" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">State</label>
                                            <input type="text" class="form-control" name="ship_to_state" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Zip</label>
                                            <input type="text" class="form-control" name="ship_to_zip" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Package Simulation -->
        <div class="card mb-4">
            <div class="card-header text-dark">Simulate Packages</div>
            <div class="card-body">
                <div >
                    <table class="table table-striped" id="packageGroupsTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Length (in)</th>
                                <th>Width (in)</th>
                                <th>Height (in)</th>
                                <th>Weight (lb)</th>
                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="package-group" id="packageGroups">
                                <td class="package-index">1</td>
                                <td>
                                    <input type="number" min="1" class="form-control" name="length[]" required>
                                </td>
                                <td>
                                    <input type="number" min="1" class="form-control" name="width[]" required>
                                </td>
                                <td>
                                    <input type="number" min="1" class="form-control" name="height[]" required>
                                </td>
                                <td>
                                    <input type="number" min="0.1" step="0.1" class="form-control" name="weight[]" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary addPackageGroupBtn">
                                        <i class="bi bi-plus-circle me-1"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Package Table -->
        <div class="card mb-4">
            <div class="card-header text-dark">Returned Rates</div>
            <div class="card-body">
                <table class="table" id="packagesTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Length (in)</th>
                            <th>Width (in)</th>
                            <th>Height (in)</th>
                            <th>Weight (lb)</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Package rows will be added here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Markup Section -->
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">Markup by State</div>
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">State</label>
                        <select class="form-control" name="markup_state" id="markup_state">
                            <option value="">Select State</option>
                            <option value="NY">NY</option>
                            <option value="NJ">NJ</option>
                            <option value="CT">CT</option>
                            <option value="PA">PA</option>
                            <option value="MA">MA</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Markup (%)</label>
                        <input type="number" min="0" step="0.01" class="form-control" name="markup_value" id="markup_value">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-warning" id="addMarkupBtn">Add Markup</button>
                    </div>
                </div>
                <table class="table table-sm mt-3" id="markupTable">
                    <thead>
                        <tr>
                            <th>State</th>
                            <th>Markup (%)</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Markup rows will be added here -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Calculate Shipping -->
        <div class="text-end">
            <button class="btn btn-lg btn-success" id="calculateShippingBtn" type="submit">Calculate Shipping</button>
        </div>
    </form>


    <script>
    $(document).ready(function() {
        // Add Package Group

    });
    </script>

</div>


@endsection
