<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link  href="{{ asset('/css/style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <title>Academy Fence Company</title>
</head>
<style>
    /* General Header Styling */
/* Basic Body Styling */
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');

body {
    font-family: 'Inter', sans-serif !important;
    font-size: 16px;
    line-height: 1.6;
    color: #333333;
    background-color: #fff;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}
/* Apply Inter font to all text elements */
body, h1, h2, h3, h4, h5, h6, p, a, button, input, select, textarea {
    font-family: 'Inter', sans-serif !important; /* Override Bootstrap's default font */
}

/* Set Inter font specifically for Bootstrap components */
.navbar, .btn, .breadcrumb, .card, .modal, .dropdown-menu, .alert, .table, .form-control {
    font-family: 'Inter', sans-serif !important;
}

.header {
    background-color: #333333;
}

/* Custom Background for Main Container */
.bg-light-custom {
    background-color: #fff;
}

/* Search Input Styling */
/* .search-input {
    width: 40% !important;
    border-radius: 0.25rem;
} */
.btn-outline-light {
    background: #fff;
    color: #000;
    font-size: 16px;
    font-weight: bold;
}
.bi-pencil-square::before {
    content: "\f4ca";
    font-size: 20px;
    margin-right: 10px;
}
/* Tagline Styling */
.tagline {
    font-weight: bold;
    color: #333;
    font-size: 35px !important;
    padding: 25px 0px;
}

/* Breadcrumb Styling */
.breadcrumb {
    margin-bottom: 0;
    font-size: 12px;
}

/* Quote Button Styling */
#btn-quote {
    background-color: #882905;
    color: #fff;
    font-weight: bold;
    border: none;
}

#btn-quote:hover {
    background-color: #F6B453;
    color: #882905;
}

/* Wood Fence Button Styling */
.btn-wood-fence {
    background-color: #F6B453;
    color: #333;
    font-weight: bold;
    border: none;
}

.btn-wood-fence:hover {
    background-color: #f9cd82;
    color: #333;
}
.quote-btn{
    background: #882905;
    border:none;
    font-size: 14px;
    padding: 10px 20px;
    text-transform: uppercase;

}
.quote-btn:hover {
    background: #F6B453;
    opacity: 80%;
    color: red;
    font-size: 14px;
    font-weight: bold;
}
/* Custom styles for navigation buttons */
.nav-btn {
    background-color: #F6B453; /* Light orange color */
    color: #333; /* Dark text color */
    font-weight: bold;
    border-radius: 5px; /* Rounded corners */
    margin: 0 5px; /* Spacing between buttons */
    padding: 15px 35px;
    text-align: center;
    display: inline-block;
}

.nav-btn:hover {
    background-color: #e68a00; /* Darker shade on hover */
    color: #fff; /* White text on hover */
    text-decoration: none;
}

/* Dropdown button styling */
.dropdown-toggle::after {
    margin-left: 5px;
}

.dropdown-menu {
    min-width: 150px; /* Width of dropdown menu */
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f4a261; /* Same color as buttons on hover */
    color: #333;
}

/* Additional styling for button text alignment */
.nav-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.nav-btn i {
    margin-right: 5px;
    color: black;
    font-size: 24px;
}
.text-light{
    text-decoration: none;
}

.text-light i{
    font-size: 25px;
    margin-left:5px;
}
.bi-person-circle::before{
    margin-right: 10px !important; 
}
.bi-cart::before{
    margin-right: 10px !important; 
}
.bi-geo-alt::before {
    content: "\f3e8";
    background: #000;
    color: #fff;
    padding: 5px;
    border-radius: 16px;
    font-size: 22px;
}
.bi-telephone::before{
    background: #000;
    color: #fff;
    padding: 6px;
    border-radius: 16px;
    font-size: 22px;
}
/* Footer Styling */
.footer {
    background-color: #000;
    color: #ffffff;
}

.footer h5 {
    font-weight: bold;
}

.footer-logo {
    width: 100px;
}

.btn-quote {
    background-color: #882905;
    color: #fff;
    font-weight: bold;
    border: none;
    padding: 0.5em 1.5em;
}

.btn-quote:hover {
    background-color: #F6B453;
    color: #882905;
}

.footer ul {
    padding-left: 0;
}

.footer ul li a {
    text-decoration: none;
    color: #ffffff;
}

.footer ul li a:hover {
    text-decoration: underline;
}

.office-hours p {
    margin: 0;
}

.footer p {
    margin: 0;
}

.footer a {
    color: #ffffff;
}

.footer a:hover {
    color: #F6B453;
}

</style>
<body style = "font-family: 'Inter', sans-serif">
    @include('layouts.header') <!-- Include the header -->

    <!-- Main Content -->
    <main class="container">
        <h1>Welcome to the Academy Fence Company</h1>
        <!-- Other content for the index page -->
    </main>
    @include('layouts.footer') <!-- Include the footer -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
