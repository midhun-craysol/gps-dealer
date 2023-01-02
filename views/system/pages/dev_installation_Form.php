
   
     <div class="container">
      <div class="row ">
         <div class="col-md-12">
            <p class="text-center text-uppercase fw-bold" style="color:#005daa">Vehicle List</p>           
         </div>
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>
         <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div class="text-center">
               <div class="input-group mb-3">
               <!-- <input type="text" class="form-control" id="VehRegNum" name="VehRegNum" placeholder="Vehicle" aria-label="Vehicle" aria-describedby="basic-addon2">
               <ul id="searchResult"></ul> -->

               <input class="form-control" name="VehSearch" id="VehSearch" placeholder="Type to search..." type="search" aria-controls="DevInstallationTable">
                     
               </div>
            </div>
         </div>
      </div>
     </div>
      <div class="row" id="VehList" data-role="page"  style="overflow-y: scroll;
    height: 500px;">   
      </div> 
     </div>
      <script>
             
             $(document).ready(function (){
            
               $("#VehSearch").keyup(function(){
                  var searchVal=$("#VehSearch").val();
                     VehSearch(searchVal);
                     });

                 getDeviceVehList('<?php echo $_SESSION['DevInstallationLogID']; ?>');
             });
          <?php echo $_SESSION['DevInstallationLogID'];?>
             function boxinfo(tx){
               $(tx).parent().submit();
                
             }
       </script>  