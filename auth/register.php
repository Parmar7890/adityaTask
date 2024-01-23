<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Registration Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!--contry code-->
  <link rel="stylesheet" href="../plugins/countrycode/build/css/intlTelInput.css">
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <style>
    .iti__country-list {
      overflow-y: scroll;
    }

    .iti__country {
      outline: none;
      /* width: 320px; */
      background-color: #fff;
    }

    .iti__dropdown-content {
      width: 320px !important;
    }
  </style>
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="register-logo">
      <a href="../../index2.html"><b>Admin</b>LTE</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register a new membership</p>

        <form method="post" id="registerForm">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="first name" name="fname" id="fname">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <span id="errFname" style="color:red;"></span>
          <div class="input-group mb-3">
            <input type="text" class="form-control" name="lname" id="lname" placeholder="last name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div>
              <select id="telephone" class="form-control">
                <option value="">

                </option>
              </select>
            </div>
            <input type="text" class="form-control" name="phone" id="phone" placeholder="phone" maxlength="10" >
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" autocomplete="off" name="email" id="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" autocomplete="off" name="password"
              id="password">
            <div class="input-group-append">
              <div class="input-group-text">

                <span id="eye" class="fas fa-eye-slash"></span>

              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="agreeTerms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>

            <!-- /.col -->
            <div class="col-4">
              <button type="submit" id="submit" name="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>

        </form>

        <div class="social-auth-links text-center">
          <p>- OR -</p>
          <a href="#" class="btn btn-block btn-primary">
            <i class="fab fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fab fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>

        <a href="login.html" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <script src="../plugins/countrycode/build/js/intlTelInput-jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/additional-methods.min.js"></script>


  <script src="../plugins/toastr/toastr.min.js"></script>
  <script>


    $("#telephone").intlTelInput({
      initialCountry: "auto",
      geoIpLookup: function (success, failure) {
        $.get("https://ipinfo.io", function () { }, "jsonp").always(function (resp) {
          var countryCode = (resp && resp.country) ? resp.country : "in";
          success(countryCode);
        });
      },
    });

    $(document).ready(function () {
      $("#eye").click(function () {
        var password = $("#password");
        var eye = $("#eye");
        eye.toggleClass("fas fa-eye fas fa-eye-slash");
        if (password.attr("type") == "password") {
          password.attr("type", "text");
        } else {
          password.attr("type", "password");
        }
      });
    });

    // $("#errFname").text("");
    $("#registerForm").validate({
      
      rules: {
        fname: {
          required: true,
          minlength: 2,
          // pattern: /^[0-9]+$/,
          pattern: /^[A-Za-z]+$/,
          lettersonly: true
        },
        lname: {
          required: true,
          minlength: 2,
          pattern: /^[A-Za-z']+$/,
          lettersonly: true
        },
        phone: {
          required: true,
          pattern: /^[+]?[1-9][0-9]{9,14}$/,
          maxlength:10,
          digits: true
          

        },
        email: {
          required: true,
          pattern: /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/
        },
        password: {
          required: true,
          pattern: /^[a-zA-Z0-9]*[!@#$%^&*()_+={}\[\]:;<>,.?\/~\\|-][a-zA-Z0-9]*$/,
          minlength: 6,


        },
        agreeTerms: {
          required: true
        }
      },
      messages: {
        fname: {
          required: "fname is required",
          minlength: "fname minimum should 2",
          pattern: "fname should only contain alphabets",
          lettersonly:"number is not allow"
        },
        lname: {
          required: "lname is required",
          minlength: "fname minimum should 2",
          pattern: "fname should only contain alphabets",
        },
        phone: {
          required: "phone is required",
          digits: "only number number is valid",
         
        },
        email: {
          required: "email is required",
          pattern: "Please enter a valid email address"

        },
        password: {
          required: "password is required",
          pattern: "invlid password",
          minlength: "minimum password lenth 6",

        },
        agreeTerms: {
          required: "agreeTerms is required"
        },
        submitHandler: function (form) {
              console.log('test');
              form.submit();
          }
      }
    });

  </script>

  <script>
    $(document).ready(function () {
      // $("#submit").click(function () {
        
        // event.preventDefault();
        // let isValid = $("#registerForm").valid();
        // if(isValid){
          submitHandler: function(form) {
          var frm = $("#registerForm").serializeArray();
          $.ajax({
            type: "POST",
            url: "../backend/authcontroller.php",
            data:JSON.stringify({
              action:'registernew',
              data:frm,
            }),
            dataType:"json",
            success: function (response) {
              console.log(response);
              console.log(response["status"])
              if (response["status"] == 200) {
                // <!-- window.location.href = "../index.php"; -->
                toastr.error(response["message"])
                                // window.location.href = "./.php";
            }
            else {
                toastr.error(response["message"]);
            }
            },
            error: function (xhr, status, error) {
              console.error(error);
            }
          })
        } 
        


      // })
    })

  </script>
</body>

</html>