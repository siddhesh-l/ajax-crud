<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
   <title>Document</title>
   <style>
      .gradient-background {
         background: linear-gradient(135deg, #d9ffbd, #9effdf, #fdbdff,#cfc2ff);
         height: 723px;
      }
      .card-shadow{
         box-shadow: 5 10px 10px rgba(0, 0, 0, 0.1);
      }
      
   </style>

</head>

<body class="gradient-background">
   <div class="container ">
         <div class="row justify-content-center">
            <div class="col-md-5 p-5 mr-2">
               <div class="card h-56 card-shadow" style="width:25rem;">
                  <div class="card-body">
                     <h3 class="text-center mb-4">Login</h3>
                     <form action="../Forms/backend/login.php" method="post">
                        <div class="form-floating mb-3">
                           <input type="email" class="form-control form-control-sm" name="floatingEmail" id="email" required placeholder="Email">
                              <label for="floatingEmail"><h6>User Name</h6></label>
                        </div>
                        <div class="form-floating mb-3">
                           <input type="password" class="form-control" name="flotingPassword" id="password" placeholder="Password" required>
                           <label for="flotingPassword"><h6>Password</h6></label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                        <p>Do not have any account? <a href="http://localhost/siddhesh/Forms/backend/">Register</a></p>
                        </div>
                     </form>
                  </div>
               </div>
               
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js"
      integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa"
      crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>