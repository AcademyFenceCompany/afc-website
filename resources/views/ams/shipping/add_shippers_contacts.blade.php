@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>ADD ADDITIONAL SHIPPER CONTACT</h2>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Add Shipper Contacts</div>
                <div class="card-body">
                    <div class="row mb-3">

                        <!-- Shipper Information Dropdown -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="shipper_type" class="form-label">Shipper Information</label>
                                <div class="dropdown-wrapper position-relative">
                                    <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                                    <select id="shipper_type" class="form-control" required>
                                        <option value="">Select Shipper</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Name & Title -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="shipper_name" class="form-label">Contact Name</label>
                                <input type="text" id="shipper_name" class="form-control"
                                    placeholder="Type contact name..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="shipper_title" class="form-label">Title</label>
                                <input type="text" id="shipper_title" class="form-control" placeholder="Type title..."
                                    required>
                            </div>
                        </div>

                        <!-- Phone & Cell -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="shipper_phone" class="form-label">Phone Number</label>
                                <input type="text" id="shipper_phone" class="form-control"
                                    placeholder="Type phone number..." required>
                            </div>
                            <div class="col-md-6">
                                <label for="shipper_cell" class="form-label">Cell Phone</label>
                                <input type="text" id="shipper_cell" class="form-control"
                                    placeholder="Type cell phone..." required>
                            </div>
                        </div>

                        <!-- Email & Fax -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="shipper_email" class="form-label">Email</label>
                                <input type="email" id="shipper_email" class="form-control" placeholder="Type email..."
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="shipper_fax" class="form-label">Fax</label>
                                <input type="text" id="shipper_fax" class="form-control"
                                    placeholder="Type fax number..." required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Submit & Cancel Buttons -->
        <div class="text-center mt-4 button-group">
            <button type="submit" class="btn add-shipper-btn">Add Shipper</button>
            <button type="button" class="btn cancel-btn">Cancel</button>
        </div>
    </div>



    @endsection