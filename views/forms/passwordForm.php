<div class="row row-cols-auto g-3">
    <div class="col-12">
  
            <!-- Password Modal -->
            <div class="UserPwdFrom" id="pwdFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
                       
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="border p-2 rounded">
                                <form class="row g-3" id="pwdFormUser" autocomplete="off">
                                   
                                    <div>
                                        <div class="col-12">
                                            <label class="form-label">Password<i class="text-danger">*</i></i>&nbsp;&nbsp;<i class="bi bi-eye-fill" id="ViewPwdUser" style="color:red;"></i></label></label>
                                            <input type="password" class="form-control" id="Pswd" name="Pswd">
                                            <input type="hidden" class="form-control" id="UserID" name="UserID" value="<?php echo $_SESSION['dealerapp']["UserID"];?>">
                                            
                                        </div>
                                       
                                    </div>

                                  

                                    <div class="col-12">
                                        <div class="modal-footer">
                                        <button type="button" id="RestBtn" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Reset</button>
                                        &nbsp;&nbsp;
                                            <button type="submit" name="userSubmit" id="userSubmit" class="btn btn-primary btn-sm">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>