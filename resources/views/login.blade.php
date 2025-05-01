<!DOCTYPE html>
<html lang="en">
  <head>
    <title>AcademyFence - HTML Website Template</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendor.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}" >
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet"> -->
    <style>
      body{
        color: #000;
      }
      section{
          /* padding: 10rem 0;
          border-top: 2px solid rgb(126, 126, 126);
          border-bottom: 2px solid rgb(126, 126, 126); */
      }
      header .nav-link {
          background-color: transparent;
      }
      .feature-icon-small {
        width: 3rem;
        height: 3rem;
      }
      .shipping-availability{
        background-color: #e8d7d3;
      }
      .bg-login-ams{
        background-image: url('{{asset('assets/images/homepage_fence.png')}}');
        background-color:#797979;
        background-position:bottom;
        background-repeat: repeat-x;
        background-size: 40%;
        height: 100vh;
      }
    </style>
  </head>
  <body class="bg-login-ams">
<!-- Section: Design Block -->
<!-- Section: Design Block -->
<section class="background-radial-gradient overflow-hidden" style="height: 100vh;">
  <style>
    .background-radial-gradients{
      background-color: hsl(0, 0%, 27.5%);
      background-image: radial-gradient(650px circle at 0% 0%, hsl(0, 2.4%, 33.3%) 15%, hsl(0, 3.3%, 35.7%) 35%, hsl(0, 1.4%, 41%) 75%, hsl(0, 1.2%, 48.4%) 80%, transparent 100%), 
      radial-gradient(1250px circle at 100% 100%, hsl(0, 5%, 35.1%) 15%, hsl(0, 1.4%, 42.9%) 35%, hsl(0, 8.1%, 36.3%) 75%, hsl(0, 6.3%, 37.6%) 80%,transparent 100%);
    }

    #radius-shape-1 {
      height: 220px;
      width: 220px;
      top: -60px;
      left: -130px;
      background: radial-gradient(#6b4b00,rgb(156, 70, 18));
      overflow: hidden;
    }

    #radius-shape-2 {
      border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
      bottom: -60px;
      right: -110px;
      width: 300px;
      height: 300px;
      background: radial-gradient(#44006b,rgb(97, 9, 9));
      overflow: hidden;
    }

    .bg-glass {
      background-color: hsla(0, 0%, 100%, 0.9) !important;
      backdrop-filter: saturate(200%) blur(25px);
      border-radius: 2rem;
    }
    .form-control{
        border: 2px solid #d7d7d7;
    }
  </style>

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
          The Fencing Company<br>
          <span style="color: hsl(25, 81.1%, 75.1%)">for your project.</span>
        </h1>
        <p class="mb-4 opacity-70" style="color: hsl(0, 0.00%, 95.30%)">
        Academy Fence Company Established in the 1960's we offer a complete line of all types of fencing and railing. As installers and designers we are able to offer the best quality available in the industry.
        </p>
      </div>

      <div class="col-lg-5 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong d-none"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong d-none"></div>

        <div class="card bg-glass">
          <div class="card-body px-4 py-5 px-md-5">
            <div class="logo text-center mb-4">
              <img src="https://www.academyfence.com/images/logo.png" alt="logo" class="img-fluid">
            </div>
            <h2 class="text-center">AMS Admin Login</h2>
            <p class="text-center mb-4">Please enter your credentials to login.</p>
            <form>
              <!-- 2 column grid layout with text inputs for the first and last names -->
              <div class="row d-none">
                <div class="col-md-12 mb-4">
                  <div data-mdb-input-init="" class="form-outline">
                    <input type="text" id="form3Example1" class="form-control form-control-lg">
                    <label class="form-label" for="form3Example1">First name</label>
                  </div>
                  <div data-mdb-input-init="" class="form-outline">
                    <input type="text" id="form3Example2" class="form-control">
                    <label class="form-label" for="form3Example2">Last name</label>
                  </div>
                </div>
              </div>

              <!-- Email input -->
              <div data-mdb-input-init="" class="form-outline mb-4">
              <label class="form-label" for="form3Example3">Email address</label>
                <input type="email" id="form3Example3" class="form-control form-control-lg">
              </div>

              <!-- Password input -->
              <div data-mdb-input-init="" class="form-outline mb-4">
                <label class="form-label" for="form3Example4">Password</label>
                <input type="password" id="form3Example4" class="form-control form-control-lg">
              </div>


              <!-- Submit button -->
              <button type="submit" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary btn-block mb-4 w-100 btn-lg">
                Login
              </button>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                  <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
              </div>
            </div>

            <div>
              <p class="mb-0 text-center">Don't have an account? <a href="#!" class="fw-bold">Sign Up</a>
              </p>
            </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Section: Design Block -->
<!-- Section: Design Block -->

  </body>
  <script src="{{ asset('assets/js/jquery-1.11.0.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</html>


