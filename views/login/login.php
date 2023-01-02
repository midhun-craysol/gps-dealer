<section class="vh-100" style="background-color: #3379a8;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" >
          <form method="POST" name="loginForm" id="loginForm">
            <div class="card-body p-5 ">
              <h5 class="mb-4 text-center"><b>Sign in</b></h5>
              <span id="err3" class="err3" ></span>
              <div class="form-outline mb-4">
              <label class="form-label" for="typeEmailX-2">Username<i class="text-danger">*</i></label>
                <input type="text" name="UserName" id="UserName" class="form-control form-control-lg" />
                <span id="err1" class="err1" ></span>
              </div>
              <div class="form-outline mb-4">
                <label class="form-label" for="typePasswordX-2">Password<i class="text-danger">*</i></label>
                <input type="password" name="LoginPswd" id="LoginPswd" class="form-control form-control-lg" />
                <span id="err2" class="err2" ></span>
              </div>
              <div class="row">
                <div class="col-8 text-start">
                  <div class="form-checks  mb-4">
                    <label class="form-check-label" for="form1Example3"> <a href="">Forgot password </a></label>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <button class="btn btn-primary btn-sm btn-block" type="submit">Login</button>
              </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>