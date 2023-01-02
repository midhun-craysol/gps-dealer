    </main>
       <!--start overlay-->
       <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

       <!--Start Back To Top Button-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
       <!--End Back To Top Button-->

  </div>
  <!--end wrapper-->
  <div class="fixed-footer" >
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-4 col-sm-12 col-xs-12 ">Dealer App</div>
          <div class="col-md-8 col-sm-12 col-xs-12">
            <span class="f-centered">&nbsp; Copyright © 2022. <a href="#" target="_blank">Craysol </a> All rights reserved.</span>
          </div>
        </div>
      </div>
  </div>

  <!-- Bootstrap bundle JS -->
  <script src="<?php echo(BASE_URL); ?>assets/js/jquery.js"></script>
  <script src="<?php echo(BASE_URL); ?>assets/js/bootstrap.min.js"></script>
  <!-- <script src="<?php echo(BASE_URL); ?>assets/js/form-validation.js"></script> -->
  <script src="<?php echo(BASE_URL); ?>assets/custom-js/helper/form.js" ></script> 
  

<script>
  var transalateText = "";
var ASSETURL = "http://localhost/dealer_app/assets/";

$(".menuItemX").on("click",function(e){
      routeURL = $(this).data("href");
      e.preventDefault();
      $.ajax({
              type: 'POST', 
              data:{dAccess:"dashboard"},
              url: BASEURL+routeURL,
              success: function(resultData) {                          
                $("#mainContentArea").html(resultData); 
                var url= window.location.pathname; 
                var valuex = url.substring(url.lastIndexOf('/')+1);         
                // $("#breadHome ").html(breadHome);
                // $("#breadPage").html(breadPage);
              },
              error : function(error) { 
                console.log(error);
              },
              complete : function(){
              }
            });
    });



    function LogOut()
    {    
      var titleStr = "Alert : CCM";
      var MessageText = "Are you want to Logout?";
      var altStr = 'Info';
      var imgStr = ASSETURL+'images/alert-icons/infoAlert.png';
      var MessageData ="<div class='row'><div class='col-sm-2'><img src='"+imgStr+"' alt='"+altStr+"' width='50' height='50'><span style='padding:10px'></div><div class='col-sm-10'><div style='padding-top:10px;'><b> "+MessageText+"</b></div></span>"+"</div></div>";
    
      bootbox.confirm({
        title: titleStr,
          message: MessageData,
        buttons: {
          confirm: {
            label: 'Yes', 
          },
          cancel: {
            label: 'No',
          }
        },
    
      // bootbox.confirm({
      //   message: "Are you want to Logout?",
      //   buttons: {
      //       confirm: {
      //           label: 'Yes'
      //       },
      //       cancel: {
      //           label: 'No'
      //       }
      //   },
        callback: function (result) {
          
          if(result==true) {
            $.ajax({
            type: 'POST',
            url: BASEURL+"logout",
            data: {},
            dataType: "json",         
            success: function(resultData) { 
            if(resultData=="1")
            {
              window.location = BASEURL+"login";
            }
              // console.log("here");
            },
            error : function(error) { 
              location.reload(); 
            }
          });
          }
        }
    });

  }

  
</script>

</body>

</html>