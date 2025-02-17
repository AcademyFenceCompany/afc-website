@extends('layouts.ams')

@section('title', 'Activity')

@section('content')

<div class="container">
    <!-- Page Title -->
    <div class="row add_product__title text-center">
        <h2>ADD SHIPPERS</h2>
    </div>

    <div class="row">
        <!-- Left Column - Shipper Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Information About Shipper</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="shipper_name" class="form-label">Shipper Name</label>
                            <input type="text" id="shipper_name" class="form-control" placeholder="Type shipper name..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="shipper_website" class="form-label">Shipper's Website</label>
                            <input type="text" id="shipper_website" class="form-control"
                                placeholder="Type shipper's website..." required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="shipper_type" class="form-label">Shipper Type</label>
                            <div class="dropdown-wrapper position-relative">
                                <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                                <select id="shipper_type" class="form-control" required>
                                    <option value="">Select Type</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="carrier_dispatcher" class="form-label">Carrier Dispatcher:</label>
                            <input type="text" id="carrier_dispatcher" class="form-control"
                                placeholder="Type carrier dispatcher..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="dispatch_phone" class="form-label">Dispatch Phone:</label>
                            <input type="text" id="dispatch_phone" class="form-control"
                                placeholder="Type dispatch phone..." required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="dispatch_email" class="form-label">Dispatch Email:</label>
                            <input type="text" id="dispatch_email" class="form-control"
                                placeholder="Type dispatch email..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="dispatch_fax" class="form-label">Dispatch Fax:</label>
                            <input type="text" id="dispatch_fax" class="form-control" placeholder="Type dispatch fax..."
                                required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Primary Contact Form -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Primary Contact</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_name" class="form-label">Contact Name:</label>
                            <input type="text" id="contact_name" class="form-control" placeholder="Type contact name..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_title" class="form-label">Title:</label>
                            <input type="text" id="contact_title" class="form-control" placeholder="Type title..."
                                required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="contact_phone" class="form-label">Phone:</label>
                            <input type="text" id="contact_phone" class="form-control"
                                placeholder="Type phone number..." required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_cell" class="form-label">Cell:</label>
                            <input type="text" id="contact_cell" class="form-control" placeholder="Type cell number..."
                                required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="contact_email" class="form-label">Email:</label>
                            <input type="text" id="contact_email" class="form-control" placeholder="Type email..."
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_fax" class="form-label">Fax:</label>
                            <input type="text" id="contact_fax" class="form-control" placeholder="Type fax number..."
                                required>
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