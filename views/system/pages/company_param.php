<script>
  pageName ="CompanyParamList";
</script>
<style>
  img.paramImg {
    width: 30px;
    height: 30px;
}
.btn i {
    vertical-align: middle;
    font-size: 1.rem;
    margin-top: -1em;
    margin-bottom: -1em;
    margin-left: 5px;
    color: black;
}
</style>
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
	<div class="breadcrumb-title pe-3" id="breadHome"></div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
				</li>
				<li class="breadcrumb-item active" aria-current="page" id="breadPage">Company Parameter</li>
			</ol>
		</nav>
	</div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase"><?php echo(isset($pageTitle)? $pageTitle :''); ?></h6>
<hr/>
<div class="card">
	<div class="card-body">
  <table class="table table-bordered display dataTable" id="companyparamTable" width="100%">                     
          <tbody>
              
              <?php 
              $paramKeys =[
                "SampleParam"=>"Sample Parameter"
               ];
              
                echo "</tr><thead><th width='60'>Sl No.</th><th>Name</th><th>Value</th><th width='100'>Action</th></thead></tr>";
                $textParams = ["SampleParam"];
               

                $i=0;
                $j=1;
                foreach ($paramRows as $row) { 
                  $rowCreated ='';
                  foreach ($columnArr as $key) { 
                    if($i>=0)
                    {     
                      
                      if (array_key_exists($key,$paramKeys)){
                        $paramValueIndex = $key;
                        $paramValue = $row[$key];
                        if(in_array($key,$textParams)){
                          $paramValue = '<form class="CompanyParamForm"><input class="paramInput border-0" id="'.$key.'" name="'.$key.'"  value ="'.$row[$key].'" readonly>';
                          $paramValue .= "<button id='".$key."SaveParam' type='submit' class=' invisible paramSubmit btn btn-xs' ><i class='bi bi-save'></i></button></form>";
                          $editBtn = '<button type="button" class="btn  btn-icon" onclick="editCpTxt(\''.$key.'\',\''.$row[$key].'\');"><i class="bi bi-pencil" title="Edit"></i></button>';
                          $rowCreated = '<tr><td>'.$j.'</td><td height="25">'.$paramKeys[$key].'</td><td height="20">'.$paramValue.'</td><td> '.$editBtn.'</td></tr>';  
                        }
                        }                             
                    
                    }
                  $i++;
                  $j++; 
                 
                  }
                  echo($rowCreated);
                  
                }
              ?>
            

            
          </tbody>
        </table>
  </div>
</div>  
           
  <!-- Modal -->
  <div class="modal fade" id="compparamModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Company Parameters</h5>
          <a type="button" class="close" id="btnModeClose" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </a>
        </div>
        <div class="modal-body">               
        <div class="col-md-12 px-0 stretch-card">
        <div class="card">
            <div class="card-body">

              <!-- <form class="forms-sample" action="addSysParam" enctype="multipart/form-data" method="POST"> -->
              <form class="forms-sample CompanyParamForm" id="CompanyParamForm" enctype="multipart/form-data" method="POST">
                <div class="form-group row">
                  <label for="coldisplayval" class="col-sm-4 col-form-label" id="SpaceForLabel"></label>
                  <div class="col-sm-8 " id="SpaceForInputs">                          
                  </div>
                </div>                                         
              <div id="error" class="error"></div>     
                <button type="submit" id="CompanyparamSubmit" class="btn btn-primary btn-sm float-right">Submit</button>
              </form>
            </div>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
       







